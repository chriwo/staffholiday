.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. include:: ../../Images.txt

.. _installation:

Installation
============

The extension needs to be installed as any other extension of TYPO3 CMS:

#. Switch to the module “Extension Manager”.

#. Get the extension

   #. **Get it from the Extension Manager:** Press the “Retrieve/Update”
      button and search for the extension key *staffholiday* and import the
      extension from the repository.

   #. **Use composer**: Use `composer require chriwo/staffholiday`.

#. The Extension Manager offers some basic configuration which is
   explained :ref:`here <extensionManager>`.

Preparation: Include static TypoScript
--------------------------------------

The extension ships some TypoScript code which needs to be included.

#. Switch to the root page of your site.

#. Switch to the **Template module** and select *Info/Modify*.

#. Press the link **Edit the whole template record** and switch to the tab *Includes*.

#. Select **Staff holiday (staffholiday)** at the field *Include static (from extensions):*

|img-plugin-ts|
