.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt

.. _ts:

TypoScript
==========

This page is divided into the following sections which are all configurable by using TypoScript:

.. only:: html

   .. contents::
      :local:
      :depth: 1


Constants
---------
You find the constants always in EXT:staffholiday/Configuration/TypoScript/constants.txt file. To change the settings
you can use the Constants-Editor in TYPO3 Backend. You could change the main settings with the constants. For a detailed
configuration have a look into the TypoScript Setup.

Plain Text
""""""""""

.. code-block:: text

   plugin.tx_staffholiday {
      view {
         # cat=plugin.tx_staffholiday/file; type=string; label= Path to layout root (FE)
         layoutRootPath = EXT:staffholiday/Resources/Private/Layouts

         # cat=plugin.tx_staffholiday/file; type=string; label= Path to partial root (FE)
         partialRootPath = EXT:staffholiday/Resources/Private/Partials

         # cat=plugin.tx_staffholiday/file; type=string; label= Path to template root (FE)
         templateRootPath = EXT:staffholiday/Resources/Private/Templates
      }

      settings {
         mailing {
            # cat=plugin.tx_staffholiday/string; type=string; label= Email address of sender
            senderEmail = noreply@domain.com

            # cat=plugin.tx_staffholiday/string; type=string; label= Name of the sender
            senderName = Staff holiday planner
         }
      }
   }


Table
"""""

Property prefix is plugin.tx_staffholiday.

.. t3-field-list-table::
 :header-rows: 1

 - :Property:
      Property
   :Datatype:
      Data Type
   :Description:
      Description
   :Default:
      Default Value

 - :Property:
      view.templateRootPath
   :Datatype:
      string
   :Description:
      Path to template root (FE)
   :Default:
      EXT:staffholiday/Resources/Private/Templates/

 - :Property:
      view.partialRootPath
   :Datatype:
      string
   :Description:
      Path to template partials (FE)
   :Default:
      EXT:staffholiday/Resources/Private/Partials/

 - :Property:
      view.layoutRootPath
   :Datatype:
      string
   :Description:
      Path to template layouts (FE)
   :Default:
      EXT:staffholiday/Resources/Private/Layouts/

 - :Property:
      settings.senderEmail
   :Datatype:
      string
   :Description:
      Sender email: Default sender email for all emails to the user
   :Default:
      noreply@domain.com

 - :Property:
      settings.senderName
   :Datatype:
      string
   :Description:
      Sender name: Default sender name for all emails to the user
   :Default:
      Staff holiday planner

Setup
-----
The setup file you could find always in EXT:staffholiday/Resources/Configuration/TypoScript/setup.txt. With this
TypoScript settings you are able to configure:

- Configure search fields of frontend user
- Define the size of frontend user image
- Overwrite any email settings
- Change CSS and JavaScript includes

Plain Text
""""""""""

.. code-block:: text

   plugin.tx_staffholiday {
       view {
           layoutRootPaths {
               0 = EXT:staffholiday/Resources/Private/Layouts
               1 = {$plugin.tx_staffholiday.view.layoutRootPath}
           }
           partialRootPaths {
               0 = EXT:staffholiday/Resources/Private/Partials
               1 = {$plugin.tx_staffholiday.view.partialRootPath}
           }
           templateRootPaths {
               0 = EXT:staffholiday/Resources/Private/Templates
               1 = {$plugin.tx_staffholiday.view.templateRootPath}
           }
       }

       settings {
           list {
               filter {
                   fieldsToSearch = user.first_name, user.last_name, user.name
               }

               image {
                   width = 50c
                   height = 50c
               }
           }

           new {
               confirmByAdmin = 1
               confirmPageTypeNum = 1504773051

               email {
                   createAdminConfirmation {
                       sender {
                           name = TEXT
                           name.value = {$plugin.tx_staffholiday.settings.mailing.senderName}

                           email = TEXT
                           email.value = {$plugin.tx_staffholiday.settings.mailing.senderEmail}
                       }

                       receiver {
                           name = TEXT
                           name.value =

                           email = TEXT
                           email.value =
                       }

                       subject = TEXT
                       subject.data = LLL:EXT:staffholiday/Resources/Private/Language/locallang.xlf:emailCreateAdminConfirmationSubject
                   }

                   createUserNotify {
                       sender {
                           name = TEXT
                           name.value = {$plugin.tx_staffholiday.settings.mailing.senderName}

                           email = TEXT
                           email.value = {$plugin.tx_staffholiday.settings.mailing.senderEmail}
                       }

                       # Overwrite Subject
                       subject = TEXT
                       subject.data = LLL:EXT:staffholiday/Resources/Private/Language/locallang.xlf:emailCreateUserNotifySubject
                   }

                   createUserNotifyRefused {
                       sender {
                           name = TEXT
                           name.value = {$plugin.tx_staffholiday.settings.mailing.senderName}

                           email = TEXT
                           email.value = {$plugin.tx_staffholiday.settings.mailing.senderEmail}
                       }

                       # Overwrite Subject
                       subject = TEXT
                       subject.data = LLL:EXT:staffholiday/Resources/Private/Language/locallang.xlf:emailCreateUserNotifyRefusedSubject
                   }
               }
           }
       }
   }

   #################################
   # Inlude CSS and JavaScript files
   #################################
   page {
      includeCSS {
         tx-staffholiday = EXT:staffholiday/Resources/Public/Css/_staffholiday.css
      }
      includeJSFooter {
         tx-staffholidy = EXT:staffholiday/Resources/Public/JavaScript/staffholiday.js
      }
   }

