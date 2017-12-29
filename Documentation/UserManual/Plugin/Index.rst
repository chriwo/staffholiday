.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. include:: ../../Images.txt

.. _plugin:

Plugin
------


.. _plugin-list:

List
^^^^
The list action displays a list of defined records. It's possible to configure the output over the list settings.

.. t3-field-list-table::
 :header-rows: 1

 - :Tab:
      Tab
   :Field:
      Field name
   :Description:
      Description
   :Default:
      Default Value

 - :Tab:
      General settings
   :Field:
      Output option
   :Description:
      Choose between "List all holiday vacation" and "Create new holiday request"
   :Default:
      [empty]

 - :Tab:
      List view
   :Field:
      Show notice to holiday vacation
   :Description:
      Display notice to a holiday vacation
   :Default:
      1

 - :Tab:
      List view
   :Field:
      Staff to show
   :Description:
      Select one user to show their vacation list. This can be left empty if this view is only visited from listview.
   :Default:
      [empty]

 - :Tab:
      List view
   :Field:
      Display staff from user group
   :Description:
      Define the user group(s) to output only staff holiday vacation of that group(s)
   :Default:
      [empty]

 - :Tab:
      List view
   :Field:
      Don't show expired vacations
   :Description:
      Define if expired vacations exclude from output
   :Default:
      0

 - :Tab:
      List view
   :Field:
      Show filer
   :Description:
      Define if you display a filter function
   :Default:
      0

 - :Tab:
      List view
   :Field:
      Limit
   :Description:
      Define the limit of entries. Default is 0, so all vacations are displayed
   :Default:
      0

 - :Tab:
      List view
   :Field:
      Order entries by
   :Description:
      Sort the entries by "Holiday begin", "Holiday end" or "User"
   :Default:
      Holiday begin

 - :Tab:
      List view
   :Field:
      Sorting entries
   :Description:
      Define the sorting direction
   :Default:
      Ascending

|plugin-list-general|

|plugin-list-options|


.. _plugin-detail:

New
^^^
The new action display a form in frontend that's allow to create new holiday vacations. In the settings of the plugin you
can define, if the request needs to be approved or not.

.. t3-field-list-table::
 :header-rows: 1

 - :Tab:
      Tab
   :Field:
      Field name
   :Description:
      Description
   :Default:
      Default Value

 - :Tab:
      General settings
   :Field:
      Output option
   :Description:
      Choose between "List all holiday vacation" and "Create new holiday request"
   :Default:
      [empty]

 - :Tab:
      New
   :Field:
      Application must be approved
   :Description:
      Define if an vacation must be approved by admin
   :Default:
      1

|plugin-new-general|

|plugin-new-options|
