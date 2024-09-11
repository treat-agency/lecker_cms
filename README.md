# Table of content

- [Backend](#backend)

  - [Setting up a new project](#setting_up_a_new_project)
  - [Logic and Naming](#logic_and_naming)
  - [Controllers](#controllers)
  - [Models](#models)
  - [Tables](#tables)
  - [Editor](#editor)

- [Frontend](#frontend)

- [User Experience](#user_experience)
  - [Project options](#project_options)
  - [Lecker](#lecker)
    - [Dashboard](#dashboard)
    - [Menu](#dashboard)
    - [Settings](#settings)
    - [Editor](#editor)
    - [Image_Repository](#image_repository)
      - [Repository overview](#repository_overview)
      - [Tease image selector](#tease_image_selector)
  

# Backend

## Setting up a new project

- **Starting a new project**

- copy empty_8 db structure and data, copy the empty_8 project on test server
- search for // treatstart comment to set db and other general settings

- **Seeing changes in the browser (live-reload)**
- in a terminal, run npm install
- in a terminal, run npm run watch to live-reload your browser on file changes
  (it watches localhost:8888 by default, you can change this in the package.json file)

## Logic and Naming

- **Entity** - is a class that represents a table in the database. In this class, you can define the table columns, relationships with other entities, and so on.
- **Repository** - is a class that contains all the data access logic. In other words, it contains the logic for retrieving, persisting, and querying data.

## Controllers

## Models

- universal models can be added at /system/core/Model.php

| function                        | description                                                                                                                               |
| ------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------- |
| getTeaserImagesForEntityAndType | getting relation between entity and image based on type_id and entity_id, optional parameter has_article if you have entity with articles |

- other models like Frontend_model, Backend_model, etc. can be found at /application/models

## Tables


## Editor

- **Custom buttons** - edit_teaser

# Frontend

# User Experience

## Lecker

### Dashboard

IMG

Dashboard is divided into three parts

- **Default dashboard** providing information and easy access to articles, tags and image repository

### Menu

IMG

Menu is set by developer and is divided into groups:

- Normal project user has available Content, General, Repositories.
- Projects with shop have additional category Shop
- Developers have additional category Dev Area

### Settings

IMG
IMG customize

Here you can change your user data or customize your dashboard.

### CRUD General

crud.php is divided into php files for better editing.

Module_Content.php specifies on top module names, keys, related items and then it takes care of saving, deleting, cloning. If there is error encountered it is saved into Error Logs



### Editor

## Dev Area
### Error Log

- this table contains error logs that are saved either manually or by function specified in MY_Controller.php


### Editor table

For Entity you can see teaser images and count of teaser images in a corner. After clicking on teaser image, you will open teaser image selector.


### Image Repostory

Images can be set as public. If they are not public, they won't be displayed anywhere in frontend and in backend they will be displayed with blur.

#### Repository overview

#### Tease image selector

Content is used
“# text in readme”
