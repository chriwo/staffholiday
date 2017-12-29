.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


ViewHelpers of EXT:staffholiday
===============================

ViewHelpers are used to add logic inside the view.
There basic things like if/else conditions, loops and so on. The system extension fluid has the most important
ViewHelpers already included.

To be able to use a ViewHelper in your template, you need to follow always the same structure which is:

.. code-block:: html

	<f:fo>bar</f:fo>

This would call the ViewHelper fo of the namespace **f** which stands for fluid.
If you want to use ViewHelpers from other extensions you need to add the namespace
declaration at the beginning of the template. The namespace declaration for the staffholiday extension is:

.. code-block:: html

	{namespace chriwo=ChriWo\Staffholiday\ViewHelpers}


Now you can use a ViewHelper of staffholiday with a code like:

.. code-block:: html

	<chriwo:firstImage string="image1.jpg,image2.png"/>

You could also use an autocompletion in your IDE by using an html-tag around your html code.

Example:

.. code-block:: html

   <html xmlns:f="https://xsd.chriwo.de/ns/typo3/cms-fluid/master/ViewHelpers"
			data-namespace-typo3-fluid="true">

      here comes your html code

   </html>


All ViewHelpers
---------------

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   FirstImageViewHelper

   Form/YearsPlanViewHelper
