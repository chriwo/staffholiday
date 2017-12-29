.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt
.. include:: ../../../Images.txt

.. _extensionManager:

Extension Manager
-----------------

Some general settings can be configured in the Extension Manager.
If you need to configure those, switch to the module "Extension Manager", select the extension "**staffholiday**"
and press on the configure-icon!

|img-extensionmanager-configuration|

The settings are divided into several tabs and described here in detail:

Properties
^^^^^^^^^^

.. container:: ts-properties

	==================================== ====================
	Property                             Default
	==================================== ====================
	disableLog_                          0
	hideHolidayPlanTable_                0
	dateTimeHoliday_                     datetime
	==================================== ====================

Property details
^^^^^^^^^^^^^^^^

.. only:: html

   .. contents::
        :local:
        :depth: 1

.. _extensionManagerDisableLog:

disableLog
""""""""""
Define if the activity are logged

.. _extensionManagerHideHolidayPlanTable:

hideHolidayPlanTable
""""""""""""""""""""
Define if the records of holiday plan are display in Backend. If not, the records are only displayed in the FeUsers
as Inline relation records.

.. _extensionManagerDateTimeHoliday:

dateTimeHoliday
"""""""""""""""
Define if you need time specification for the vacations.
