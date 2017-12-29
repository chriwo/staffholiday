YearsPlanViewHelper
-------------------

ViewHelper to return an array of years of holiday entries.


General properties
^^^^^^^^^^^^^^^^^^

.. t3-field-list-table::
 :header-rows: 1

 - :Name: Name:
   :Type: Type:
   :Description: Description:
   :Default value: Default value:

 - :Name:
         excludeExpired
   :Type:
         boolean
   :Description:
         Optional parameter to exclude requests that have been rejected
   :Default value:
         false

Example
^^^^^^^

Basic
"""""

Code: ::

	 <chriwo:form.yearsPlan/>

Output: ::

	 Array with the years as index and value
	 [
	   2016 => 2016
	   2017 => 2017
	 ]


With exclude parameter
""""""""""""""""""""""

Code: ::

   <chriwo:form.yearsPlan excludeExpired="false"/>

Output: ::

	 Array with the years as index and value. The year 2016 is exclude, because all vacation requests were rejected.
	 [
	   2017 => 2017
	 ]

