/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Stephen Bungert <stephenbungert@yahoo.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * The JavaScrpt for the import BE module.
 * Requires ExtJs
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
function sb2Importer ()
{
		// Misc
	var startImportPressed	  	= false;
	var relatedLastType		 	= false;
	var relatedCount			= 1;
	var translatedLastType		= false;
	var translatedCount			= 1;
	var relatedCounts		   	= new Array();
	var translatedCounts	   	= new Array();
	var ajaxQueueTranslation	= [];
	var ajaxQueueRelated		= [];
	var ajaxQueue			   	= [];
	var pageId				  	= 0;
	var useBranch			   	= false;
	var resultsContainer		= '';
	var noCriticalErrors		= true;
	var recsPerRow			  	= 2;
	var errMsgContainerVisible  = false;

		// HTML
	var clearer			 	= '<div class="sbp2Clearer"></div>';
	var clearerRecordTitle  = '<div class="sbp2Clearer sbp2RecordTitleClearer"></div>';
	var recRow			  	= '<div class="sbp2RecordRow"></div>';
	var recRowLast		  	= '<div class="sbp2RecordRow sbp2RecordRowLastOfType"></div>';
	var recStartA		   	= '<div class="sbp2Record"';
	var recStartB		   	= '>';
	var recEnd			  	= '</div>';
	var typeStart		   	= '<h2 class="sbp2Para sbp2Type">';
	var typeEnd			 	= '</h2>';
	var iconStart		   	= '<span class="sbp2RecordIcon">';
	var iconEnd			 	= '</span>';
	var tableStart		  	= clearer + '<table class="sbp2ChildTable"><tbody>';
	var tableEnd			= '</tbody></table>';
	var rowStart			= '<tr>';
	var rowEnd			  	= '</tr>';
	var cellStartIcon	   	= '<td class="sbp2CellIcon">';
	var cellStartMsg		= '<td class="sbp2CellMsg">';
	var cellStart		   	= '<td class="sbp2CellTitle">';
	var cellEnd			 	= '</td>';
	var newCell			 	= cellEnd + cellStart;
	var emptyCellContent	= '&nbsp;';
	var waitingRelated	  	= '<p class="sbp2WaitingMsg sbp2WaitingMsg-related loading-indicator">';
	var waitingTranslation  = '<p class="sbp2WaitingMsg sbp2WaitingMsg-translation loading-indicator">';

	/**
	 * Starts the import process
	 *
	 * @return void
	 *
	 */
	function startImport()
	{
		if (noCriticalErrors)
		{
			pageId			  = getCurrentPageId();
			resultsContainer	= Ext.get('sbp2ResultsContainer');

			clearResultsContainer();

			if (pageId <= 0) // No page ID found
			{
				hideImportSubmitButton();
				showErrorMessage(sbp2Msgs['noPageId']);
				noCriticalErrors = false;
			}
			else // Start importing...
			{
				buildQueue();

				if (ajaxQueue.length > 1)
				{
					hideImportSubmitButton();
					hideCompletedMessage();
					makeAjaxRequest(true);
				}
				else
				{
					alert(sbp2Msgs['noCountOnPage']);
				}
			}
		}
	}

	/**
	 * Builds the queue for AJAX requests.
	 *
	 * @return void
	 *
	 */
	function buildQueue()
	{
		var numOfRecordTypes	= sbp2Data.length;
		var count			   = 1;

			// Build queue
		for (var typeIndex = 0; typeIndex < numOfRecordTypes; typeIndex ++)
		{
			var recCount		= parseInt(sbp2Data[typeIndex]['count']);
			var recIndexCount   = 1;

			if (useBranch)
			{
				recCount = parseInt(sbp2Data[typeIndex]['countBranch']);
			}

			if (recCount >= 1)
			{
				for (var requestIndex = 0; requestIndex < recCount; requestIndex ++)
				{
					var newQueueRec = {
						'count' :		   	count,
						'requestIndex' :	requestIndex,
						'typeIndex' :	   	typeIndex,
						'rowEnd' :		  	false,
						'lastOfType' :	  	false,
						'firstOfType' :	 	false
					}

					if (recIndexCount == recsPerRow)
					{
						recIndexCount = 1;
						newQueueRec.rowEnd = true;
					}
					else
					{
						recIndexCount ++;
					}

					if (requestIndex == recCount - 1)
					{
						newQueueRec.lastOfType = true;
					}

					if (requestIndex == 0)
					{
						newQueueRec.firstOfType = true;
					}

					ajaxQueue.push(newQueueRec);

					count ++;
				}
			}
		}
	}

	/**
	 * Submits an import AJAX request
	 *
	 * @return void
	 *
	 */
	function ajaxRequest(queueItem)
	{
		var requestIndex		= queueItem['requestIndex'];
		var typeIndex		   	= queueItem['typeIndex'];
		var branchIds		   	= '&sbp2BranchIds=0';
		var storageTags		 	= parseInt(Ext.get('sbp2ImportStorageTags').dom.value);
		var storageFiles		= parseInt(Ext.get('sbp2ImportStorageFiles').dom.value);
		var storageClients	  	= parseInt(Ext.get('sbp2ImportStorageClients').dom.value);
		var storageCategories   = parseInt(Ext.get('sbp2ImportStorageCategories').dom.value);

		if (storageTags < 1)
		{
				storageTags = sbp2Be['storagePid'];
		}

		if (storageFiles < 1)
		{
				storageFiles = sbp2Be['storagePid'];
		}

		if (storageClients < 1)
		{
				storageClients = sbp2Be['storagePid'];
		}

		if (storageCategories < 1)
		{
				storageCategories = sbp2Be['storagePid'];
		}

		if (useBranch)
		{
			branchIds = '&sbp2BranchIds=' + sbp2Be['branchPids'];
		}

		new Ajax.Request('ajax.php', {
				method: 'POST',
				parameters: 'ajaxID=tx_sbportfolio2::import&sbp2PageId=' + pageId + '&sbp2StorageClients=' + storageClients + '&sbp2StorageCategories=' + storageCategories + '&sbp2StorageTags=' + storageTags + '&sbp2StorageFiles=' + storageFiles + '&sbp2Repo=' + Ext.encode(sbp2Data[typeIndex]['repo']) + '&sbp2Type=' + Ext.encode(sbp2Data[typeIndex]['type']) + '&sbp2RequestIndex=' + requestIndex + branchIds,
				onComplete: function(responseObject, json) {
					if (responseObject.status == 500)
					{
						showErrorMessage(responseObject.responseText);
					}
					else // It went ok, let the user know what was imported
					{
						var decodedRecord = Ext.decode(responseObject.responseText);

						if (resultsContainer)
						{
								// Now process this record
							var sbp2Rec			= decodedRecord.sbpRec['title'];
							var sbp2Related		= '';
							var sbp2Translation	= '';

								// Add to related item queue, if required
							if (decodedRecord.sbpRec['relateditems'] > 0)
							{
								var newRelatedQueueRec = {
									'requestIndex' :	relatedCount,
									'uid' :				decodedRecord.sbpRec['uid'],
									'title' :			sbp2Rec,
									'typeIndex' :		typeIndex
								}

								ajaxQueueRelated.push(newRelatedQueueRec);
								sbp2Related = waitingRelated;

								relatedCount ++;

								if (!relatedCounts[sbp2Data[typeIndex]['type']])
								{
									relatedCounts[sbp2Data[typeIndex]['type']] = 0;
								}

								relatedCounts[sbp2Data[typeIndex]['type']] ++;
							}

								// Add to translation record queue, if required
							if (decodedRecord.sbpRec['l10n_parent'] > 0)
							{
								var newTranslatedQueueRec = {
									'requestIndex' :	translatedCount,
									'uid' :			 	decodedRecord.sbpRec['uid'],
									'title' :		   	sbp2Rec,
									'parent' :		   	decodedRecord.sbpRec['l10n_parent'],
									'typeIndex' :	   	typeIndex
								}

								ajaxQueueTranslation.push(newTranslatedQueueRec);
								sbp2Translation = waitingTranslation;

								translatedCount ++;

								if (!translatedCounts[sbp2Data[typeIndex]['type']])
								{
									translatedCounts[sbp2Data[typeIndex]['type']] = 0;
								}

								translatedCounts[sbp2Data[typeIndex]['type']] ++;
							}

								// See if a child objects table is needed
							if (decodedRecord.numOfChildren > 0)
							{
								childTable = '';
								childTable = addChildTable(decodedRecord, childTable, typeIndex);

									// Add record icon and title and child table
								addResultsRecord(sbp2Rec + childTable + sbp2Related + sbp2Translation, typeIndex, decodedRecord.sbpRec['uid']);
							}
							else
							{
									// Add record icon and title
								addResultsRecord(sbp2Rec + clearerRecordTitle + sbp2Related + sbp2Translation, typeIndex, decodedRecord.sbpRec['uid']);
							}

							if (ajaxQueue[0]['lastOfType'] === true)
							{
								resultsContainer.insertHtml('beforeEnd', recRowLast);
							}
							else if (ajaxQueue[0]['rowEnd'] === true)
							{
								resultsContainer.insertHtml('beforeEnd', recRow);
							}

							ajaxQueue.shift(); // Remove the just imported item from the queue

								// If there are still records queued up, import them
							if (ajaxQueue.length > 0)
							{
								makeAjaxRequest();
							}
							else // Or, if none are left to import, start making related items
							{
									// Inform user what is happening...
								if (ajaxQueueRelated.length > 0)
								{
									makeAjaxRequestRelated();
								}
								else
								{
									hideLoadingMessage();
									showCompletedMessage();
								}
							}
						}
					}

				}.bind(this),
				onT3Error: function(responseObject, json) {
				}.bind(this)
		});
	}

	/**
	 * Performs an AJAX request.
	 *
	 * @return boolean isFirstRequest Is this the first AJAX request?
	 * @return void
	 *
	 */
	function makeAjaxRequest(isFirstRequest)
	{
		if (!isFirstRequest)
		{
			isFirstRequest = false;
		}

			// Inform user what is happening...
		var newCount = parseInt(sbp2Data[ajaxQueue[0]['typeIndex']]['count']);

		if (useBranch)
		{
			newCount = parseInt(sbp2Data[ajaxQueue[0]['typeIndex']]['countBranch']);
		}

		setLoadingCount(ajaxQueue[0]['requestIndex'] + 1, newCount);
		setLoadingType(sbp2Data[ajaxQueue[0]['typeIndex']]['repo']);

		if (isFirstRequest)
		{
			showLoadingMessage();
		}

		if (ajaxQueue[0]['firstOfType'] === true)
		{
			resultsContainer.insertHtml('beforeEnd', typeStart + iconStart + sbp2Assets[sbp2Data[ajaxQueue[0]['typeIndex']]['type']] + iconEnd + ' ' + sbp2Data[ajaxQueue[0]['typeIndex']]['title'] + typeEnd);
		}

			// ...and make import request
		ajaxRequest(ajaxQueue[0]);
	}

	/**
	 * Adds a table to the output.
	 *
	 * @return array decodedRecord Is this the first AJAX request?
	 * @return string childTable The child table html, if any.
	 * @return integer typeIndex The index to the type of record in the array sbp2.
	 * @return integer parentId The ID to look for in the childs parent property
	 * @return string childTable The complete HTML for the child table, or an empty string if there were no children.
	 *
	 */
	function addChildTable(decodedRecord, childTable, typeIndex, parentId)
	{
		var tableContent = '';

		for (var index = 0; index < decodedRecord.numOfChildren; index ++)
		{
			if (!parentId)
			{
				if (decodedRecord.children[index]['parent']) continue;

				tableContent += addResultsRecord(decodedRecord.children[index]['title'], typeIndex, decodedRecord.children[index]['uid'], true, getChildIcon(decodedRecord, index));

					// See if there are any children
				tableContent = addChildTable(decodedRecord, tableContent, typeIndex, decodedRecord.children[index]['id']);
			}
			else if (parentId == decodedRecord.children[index]['parent'])
			{
				tableContent += addResultsRecord(decodedRecord.children[index]['title'], typeIndex, decodedRecord.children[index]['uid'], true, getChildIcon(decodedRecord, index));
			}
		}

		var isFirstChildTable = false;

		if (childTable == '')
		{
			isFirstChildTable = true;
		}

		childTable += wrapChildTable(tableContent, isFirstChildTable);

		return childTable;
	}

	/**
	 * Creates an image tag for an icon record
	 *
	 * @return string decodedRecord The record array returned from the import request.
	 * @return string index The records index number.
	 * @return string An img tag.
	 *
	 */
	function getChildIcon(decodedRecord, index)
	{
		return '<img alt="" src="' + decodedRecord.iconPath + decodedRecord.children[index]['folder'] + '/sbp2_' + decodedRecord.children[index]['type'] + '.gif"/>';
	}

	/**
	 * If there is content for a child table, the table is wrapped in a table tag.
	 *
	 * @return string tableContent The content of the child table as a string of html.
	 * @return boolean isFirstChildTable Is this the first child table?
	 * @return mixed Nothing or the html, when it is not being added directly
	 *
	 */
	function wrapChildTable(tableContent, isFirstChildTable)
	{
		if (typeof tableContent == 'string' && tableContent != '')
		{
			var childTable = tableStart + tableContent + tableEnd;

			if (!isFirstChildTable)
			{
				childTable = rowStart + cellStartIcon + emptyCellContent + newCell + childTable + rowEnd;
			}
			else
			{
				childTable = clearerRecordTitle + childTable;
			}

			return childTable;
		}

		return '';
	}

	/**
	 * Adds a record cell to the results table.
	 *
	 * @return string recTitle The title of the record that was imported.
	 * @return integer typeIndex The index of the type of record being imported in the sbp2 array.
	 * @return string recUid The uid of the record that was imported.
	 * @return boolean returnContent Sould the content be returned instead of being added straight away to the results table?
	 * @return string recIcon The icon's img tag for the record.
	 * @return mixed Nothing or the html, when it is not being added directly
	 *
	 */
	function addResultsRecord(recTitle, typeIndex, recUid, returnContent, recIcon)
	{
		typeIndex	   = parseInt(typeIndex);
		var isChildRecord   = true;

		if (!returnContent)
		{
			returnContent = false;
		}

		if (!recIcon)
		{
			recIcon		 = '';
			isChildRecord   = false; // Only child records need an icon passing here
		}

		if (resultsContainer && typeof recTitle == 'string')
		{
			var icon = sbp2Data[typeIndex]['icon'];

			if (typeof recIcon == 'string' && recIcon != '')
			{
				icon = recIcon;
			}

			var html = '';

			if (isChildRecord)
			{
				html = rowStart + cellStartIcon + icon + newCell + recTitle + cellEnd + rowEnd;
			}
			else
			{
				html = recStartA + ' id="sbp' + sbp2Data[typeIndex]['repo'] + '-' + recUid + '"' + recStartB + iconStart + icon + iconEnd + recTitle + recEnd;
			}

			if (returnContent)
			{
				return html;
			}
			else
			{
				resultsContainer.insertHtml('beforeEnd', html);
			}
		}
	}

	/**
	 * Adds a message row to the results table.
	 *
	 * @return string msg The message to be shown in the row.
	 * @return void
	 *
	 */
	function addResultsMessage(msg)
	{
		if (resultsContainer && typeof msg == 'string')
		{
			resultsContainer.update(rowStart + cellStartMsg + msg + cellEnd + rowEnd);
		}
	}

	/**
	 * Clears the results container of content
	 *
	 * @return string msg The error message.
	 * @return void
	 *
	 */
	function clearResultsContainer()
	{
		if (resultsContainer)
		{
			resultsContainer.update('');
		}
	}

	/**
	 * Hides loading message.
	 *
	 * @return void
	 *
	 */
	function hideLoadingCount()
	{
		Ext.get('sbp2LoadingMessageCount').setVisibilityMode(Ext.Element.DISPLAY).hide();
	}

	/**
	 * Shows loading message.
	 *
	 * @return void
	 *
	 */
	function showLoadingCount()
	{
		Ext.get('sbp2LoadingMessageCount').setVisibilityMode(Ext.Element.DISPLAY).show();
	}

	/**
	 * Hides loading message.
	 *
	 * @return void
	 *
	 */
	function hideLoadingMessage()
	{
		Ext.get('sbp2LoadingMessage').setVisibilityMode(Ext.Element.DISPLAY).hide();
	}

	/**
	 * Shows loading message.
	 *
	 * @return void
	 *
	 */
	function showLoadingMessage()
	{
		Ext.get('sbp2LoadingMessage').setVisibilityMode(Ext.Element.DISPLAY).show();
	}

	/**
	 * Sets loading action.
	 *
	 * @return string loadingAction The action currently being done.
	 * @return void
	 *
	 */
	function setLoadingAction(loadingAction)
	{
		if (typeof loadingAction == 'string')
		{
			Ext.get('sbp2LoadingMessageAction').update(loadingAction);
		}
	}

	/**
	 * Sets loading type.
	 *
	 * @return string loadingType The type of record currently being processed.
	 * @return void
	 *
	 */
	function setLoadingType(loadingType)
	{
		if (typeof loadingType == 'string')
		{
			Ext.get('sbp2LoadingMessageType').update(loadingType.toLowerCase());
		}
	}

	/**
	 * Sets loading count.
	 *
	 * @return integer current The current record type count.
	 * @return integer total The total count for the record type.
	 * @return void
	 *
	 */
	function setLoadingCount(current, total)
	{
		var current = parseInt(current);
		var total   = parseInt(total);

		if ((current > 0 && total > 0) && total >= current)
		{
			var count   = ' (' + current + ' / ' + total + ')';

			Ext.get('sbp2LoadingMessageCount').update(count);
		}
	}

	/**
	 * Hides import complete message.
	 *
	 * @return void
	 *
	 */
	function hideCompletedMessage()
	{
		Ext.get('sbp2ImportComplete').setVisibilityMode(Ext.Element.DISPLAY).hide();
	}

	/**
	 * Shows import complete message.
	 *
	 * @return void
	 *
	 */
	function showCompletedMessage()
	{
		Ext.get('sbp2ImportComplete').setVisibilityMode(Ext.Element.DISPLAY).show();
	}

	/**
	 * Hides error message.
	 *
	 * @return void
	 *
	 */
	function hideErrorMessage()
	{
		Ext.get('sbp2ErrorMessage').setVisibilityMode(Ext.Element.DISPLAY).hide();
	}

	/**
	 * Shows the error message container.
	 *
	 * @return string msg The error message.
	 * @return void
	 *
	 */
	function showErrorMessage(msg)
	{
		if (!errMsgContainerVisible)
		{
			Ext.get('sbp2ErrorMessage').update('');;
			Ext.get('sbp2ErrorMessage').setVisibilityMode(Ext.Element.DISPLAY).show();
			errMsgContainerVisible = true;
		}

		addErrorMessage(msg);
	}

	/**
	 * Sets error message.
	 *
	 * @return string msg The error message.
	 * @return void
	 *
	 */
	function addErrorMessage(msg)
	{
		if (typeof msg == 'string')
		{
			Ext.get('sbp2ErrorMessage').insertHtml('beforeEnd', '<p>' + msg + '</p>');
		}
	}

	/**
	 * Hides the import submit button.
	 *
	 * @return void
	 *
	 */
	function hideImportSubmitButton()
	{
		Ext.get('sbp2ImportSubmitContainer').setVisibilityMode(Ext.Element.DISPLAY).hide();
	}

	/**
	 * Shows the import submit button.
	 *
	 * @return void
	 *
	 */
	function showImportSubmitButton()
	{
		Ext.get('sbp2ImportSubmitContainer').setVisibilityMode(Ext.Element.DISPLAY).show();
	}


	/**
	 * Gets the current page uid
	 *
	 * @return integer The page uid or 0
	 *
	 */
	function getCurrentPageId()
	{
		var thisLoc = 0;

		if (T3_THIS_LOCATION)
		{
			var t3Loc = decodeURIComponent(T3_THIS_LOCATION);
			var idPos = t3Loc.indexOf('id=');

			if (idPos >= 0)
			{
				t3Loc = parseInt(t3Loc.substr(idPos + 3)); // ParseInt will remove vars after ID, if there are any

				if (t3Loc > 0)
				{
					thisLoc = t3Loc;
				}
			}
		}

		return thisLoc;
	}

	/**
	 * Submits an import AJAX request for creating related item, can only be done after the initial import
	 * as there is no way until this done to know the UID of new sp_portfolio2 records.
	 *
	 * @return void
	 *
	 */
	function ajaxRequestRelated(queueItem)
	{
		requestIndex	= queueItem['requestIndex'];
		typeIndex	   	= queueItem['typeIndex'];
		branchIds	  	= '&sbp2BranchIds=0';

		if (useBranch)
		{
			branchIds = '&sbp2BranchIds=' + sbp2Be['branchPids'];
		}

		new Ajax.Request('ajax.php', {
			method: 'POST',
			parameters: 'ajaxID=tx_sbportfolio2::importRelated&sbp2PageId=' + pageId + '&sbp2Repo=' + Ext.encode(sbp2Data[typeIndex]['repo']) + '&sbp2Type=' + Ext.encode(sbp2Data[typeIndex]['type']) + '&sbp2RelatedUid=' + parseInt(queueItem['uid']) + '&sbp2RequestIndex=' + requestIndex + branchIds,
			onComplete: function(responseObject, json) {
				if (responseObject.status == 500)
				{
					showErrorMessage(responseObject.responseText);
				}
				else // It went ok, let the user know what was imported
				{
					var decodedResults = Ext.decode(responseObject.responseText);

					if (resultsContainer)
					{
						var wasSuccessful = false;

						if (decodedResults.success)
						{
							wasSuccessful = true;

							var sbp2RecordSelector  = '#sbp' + sbp2Data[ajaxQueueRelated[0]['typeIndex']]['repo'] + '-' + decodedResults.record.origUid;
							var targetSbp2Record	= Ext.select(sbp2RecordSelector + ' > .sbp2ChildTable > tbody');
							var newRows			 = '';

							if (decodedResults.numOfRelatedrecords > 0)
							{
									// Create rows
								for (var index = 0; index < decodedResults.numOfRelatedrecords; index ++)
								{
									var recUid	  = decodedResults.relatedrecords[index].uid;
									var recTitle	= decodedResults.relatedrecords[index].title;
									var typeIndex   = ajaxQueueRelated[0]['typeIndex'];

									var newRow = addResultsRecord(recTitle, typeIndex, recUid, true, sbp2Data[2]['icon']);

									newRows += newRow;
								}

								if (targetSbp2Record.elements.length >= 1) // There is already a child table
								{
										// Just add the new rows
									targetSbp2Record.insertHtml('beforeEnd', newRows);
								}
								else // There is no child table
								{
									targetSbp2Record = Ext.select(sbp2RecordSelector); // Change the target

										// Add a table
									var fullTable = wrapChildTable(newRows, true);

									targetSbp2Record.insertHtml('beforeEnd', fullTable);
								}
							}
							else
							{
								showErrorMessage(sbp2Msgs['noRelatedRecsFound'] + '<strong>' + queueItem['title'] + '</strong>');
							}

								// Remove waitingRelated spinner
							targetSbp2Record = Ext.select(sbp2RecordSelector + ' > .sbp2WaitingMsg-related').remove();
						}
						else
						{
							showErrorMessage(sbp2Msgs['noRelatedRecsFound'] + '<strong>' + queueItem['title'] + '</strong>');
						}

						ajaxQueueRelated.shift(); // Remove the just related records from the queue

							// If there are still records queued up, find their related records
						if (ajaxQueueRelated.length > 0)
						{
							makeAjaxRequestRelated();
						}
						else
						{
							if (wasSuccessful === false) {
									// Hide any still showing spinners
								Ext.select('.sbp2WaitingMsg-related').remove();
							}

							if (ajaxQueueTranslation.length > 0)
							{
									// Start setting the correct default language translations
								makeAjaxRequestTranslation();
							}
							else
							{
									// Inform user what is happening...
								hideLoadingMessage();
								showCompletedMessage();
							}
						}
					}
				}

			}.bind(this),
				onT3Error: function(responseObject, json) {
			}.bind(this)
		});
	}

	/**
	 * Submits an import AJAX request for records are translations, can only be done after the initial import
	 * as there is no way until this done to know the UID of new sp_portfolio2 records that are the parents of the translations.
	 *
	 * @return void
	 *
	 */
	function ajaxRequestTranslation(queueItem)
	{
		requestIndex	= queueItem['requestIndex'];
		typeIndex	   	= queueItem['typeIndex'];
		branchIds	  	= '&sbp2BranchIds=0';

		if (useBranch)
		{
			branchIds = '&sbp2BranchIds=' + sbp2Be['branchPids'];
		}

		new Ajax.Request('ajax.php', {
			method: 'POST',
			parameters: 'ajaxID=tx_sbportfolio2::importTranslation&sbp2PageId=' + pageId + '&sbp2Repo=' + Ext.encode(sbp2Data[typeIndex]['repo']) + '&sbp2Type=' + Ext.encode(sbp2Data[typeIndex]['type']) + '&sbp2TranslationParent=' + parseInt(queueItem['parent']) + '&sbp2TranslationUid=' + parseInt(queueItem['uid']) + '&sbp2RequestIndex=' + requestIndex + branchIds,
			onComplete: function(responseObject, json) {
				if (responseObject.status == 500)
				{
					showErrorMessage(responseObject.responseText);
				}
				else // It went ok, let the user know what was imported
				{
					var decodedResults = Ext.decode(responseObject.responseText);

					if (resultsContainer)
					{
						var wasSuccessful = false;

						if (decodedResults.success)
						{
							wasSuccessful = true;

							var sbp2RecordSelector  = '#sbp' + sbp2Data[ajaxQueueTranslation[0]['typeIndex']]['repo'] + '-' + decodedResults.translation.sbpuid;
							var targetSbp2Record	= Ext.select(sbp2RecordSelector + ' > .sbp2ChildTable > tbody');
							var newRows			 = '';

							if (!decodedResults.translation)
							{
								showErrorMessage(sbp2Msgs['noTranslationFound'] + '<strong>' + queueItem['title'] + '</strong>');
							}

								// Remove waitingRelated spinner
							targetSbp2Record = Ext.select(sbp2RecordSelector + ' > .sbp2WaitingMsg-translation').remove();
						}
						else
						{
							showErrorMessage(sbp2Msgs['noTranslationFound'] + '<strong>' + queueItem['title'] + '</strong>');
						}

						ajaxQueueTranslation.shift(); // Remove the just related records from the queue

							// If there are still records queued up, find their related records
						if (ajaxQueueTranslation.length > 0)
						{
							makeAjaxRequestTranslation();
						}
						else
						{
							if (wasSuccessful === false) {
									// Hide any still showing spinners
								Ext.select('.sbp2WaitingMsg-translation').remove();
							}

								// Inform user what is happening...
							hideLoadingMessage();
							showCompletedMessage();
						}
					}
				}
			}.bind(this),
				onT3Error: function(responseObject, json) {
			}.bind(this)
		});
	}

	/**
	 * Performs an AJAX request for translated records.
	 *
	 * @return void
	 *
	 */
	function makeAjaxRequestTranslation()
	{
		if (translatedLastType === false) // First related item
		{
			translatedLastType = ajaxQueueTranslation[0]['typeIndex'];
		}
		else (translatedLastType != ajaxQueueTranslation[0]['typeIndex'])
		{
			translatedLastType = ajaxQueueTranslation[0]['typeIndex'];
		}

		var translationTypeTotalount = translatedCounts[sbp2Data[relatedLastType]['type']];

			// Inform user what is happening...
		setLoadingAction(sbp2Msgs['translation']);
		setLoadingType(sbp2Data[2]['type']);
		setLoadingCount(ajaxQueueTranslation[0]['requestIndex'], translationTypeTotalount);

			// ...and make related request
		ajaxRequestTranslation(ajaxQueueTranslation[0]);
	}

	/**
	 * Performs an AJAX request for related records.
	 *
	 * @return void
	 *
	 */
	function makeAjaxRequestRelated()
	{
		if (relatedLastType === false) // First related item
		{
			relatedLastType = ajaxQueueRelated[0]['typeIndex'];
		}
		else (relatedLastType != ajaxQueueRelated[0]['typeIndex'])
		{
			relatedLastType = ajaxQueueRelated[0]['typeIndex'];
		}

		var relatedTypeTotalount = relatedCounts[sbp2Data[relatedLastType]['type']];

			// Inform user what is happening...
		setLoadingAction(sbp2Msgs['related']);
		setLoadingType(sbp2Data[2]['type']);
		setLoadingCount(ajaxQueueRelated[0]['requestIndex'], relatedTypeTotalount);

			// ...and make related request
		ajaxRequestRelated(ajaxQueueRelated[0]);
	}

	/**
	 * Set whether the imports are for the page or the branch
	 *
	 * @return void
	 *
	 */
	this.setImportType = function ()
	{
		var selValue = Ext.DomQuery.selectValue('input[name="sbp2ImportOptions"]:checked/@value');

		if (selValue == 1)
		{
			useBranch = true;
		}
		else
		{
			useBranch = false;
		}
	}

	/**
	 * Initiate importation
	 *
	 * @return void
	 *
	 */
	this.init = function ()
	{
		if (startImportPressed === false)
		{
			waitingRelated	  	+= sbp2Msgs['waitingRelated'] + '</p>';
			waitingTranslation  += sbp2Msgs['waitingTranslation'] + '</p>';
			startImportPressed  = true;
		}

		startImport();
	}
}


var sbp2ImportObj = new sb2Importer();