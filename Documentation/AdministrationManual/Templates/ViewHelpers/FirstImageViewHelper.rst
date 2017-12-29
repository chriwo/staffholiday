FirstImageViewHelper
--------------------

ViewHelper to return the first image of a list of images.


General properties
^^^^^^^^^^^^^^^^^^

.. t3-field-list-table::
 :header-rows: 1

 - :Name: Name:
   :Type: Type:
   :Description: Description:
   :Default value: Default value:

 - :Name:
         string
   :Type:
         string
   :Description:
         List of images
   :Default value:

 - :Name:
         separator
   :Type:
         string
   :Description:
         Separator char to explode the list
   :Default value:
         ,

 - :Name:
         trim
   :Type:
         boolean
   :Description:
         Option to remove empty values
   :Default value:
         true

Example
^^^^^^^

Basic
"""""

Code: ::

	 <chriwo:firstImage string="image1.jpg,image2.png"/>

Output: ::

	 image1.jpg


Get first image of semicolon list
"""""""""""""""""""""""""""""""""

Code: ::

   <chriwo:firstImage string="image1.jpg;image2.png" separator=";"/>

Output: ::

	 image1.jpg

