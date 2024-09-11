
CREATE TABLE events (
    id integer NOT NULL,
    status event_status,
    title text,
    date_start date,
    date_end date,
    date_copy text,
    venue text,
    excerpt text,
    content text,
    info_hours text,
    sidenote_title text,
    sidenote_content text,
    sponsors text,
    date_created datetime,
    date_modified datetime,
    is_support_event boolean,
    day_of_week text(3),
    alternate_title text,
    subtitle text,
    tickets_link text,
    content_details text
);
CREATE TABLE events_eventcategories (
    event_id integer NOT NULL,
    eventcategory_id integer NOT NULL
);
CREATE TABLE events_exhibitions (
    event_id integer NOT NULL,
    exhibition_id integer NOT NULL
);
CREATE TABLE events_shopitems (
    event_id integer NOT NULL,
    shopitem_id integer NOT NULL
);
CREATE TABLE exhibitions (
    id integer NOT NULL,
    status exhibition_status,
    title text,
    date_start date,
    date_end date,
    date_copy text,
    venue text,
    excerpt text,
    content text,
    centennial_hours text,
    gairloch_hours text,
    info_hours text,
    sidenote_title text,
    sidenote_content text,
    sponsors text,
    date_created datetime,
    date_modified datetime,
    subtitle text,
    alternate_title text
);
CREATE TABLE exhibitions_artists (
    exhibition_id integer NOT NULL,
    artist_id integer NOT NULL
);
CREATE TABLE exhibitions_exhibitions (
    exhibition_id integer NOT NULL,
    related_exhibition_id integer NOT NULL
);
CREATE TABLE exhibitions_shopitems (
    exhibition_id integer NOT NULL,
    shopitem_id integer NOT NULL
);
CREATE TABLE image_uploads (
    id text NOT NULL,
    path text,
    link_id integer,
    width integer,
    height integer,
    extension text(5)
);
CREATE TABLE images (
    id text NOT NULL,
    link_id integer,
    image_upload_id text,
    path text(200),
    width integer,
    height integer,
    extension text(5),
    description_en text(200),
    description_fr text(200),
    is_default integer,
    format_config text(50),
    target_link text,
    target_mode torus_images_target
);
CREATE TABLE links (
    id integer NOT NULL,
    link_type text(50),
    record_state text(50),
    date datetime
);
CREATE TABLE memberships (
    id integer NOT NULL,
    status membership_status,
    mtype membership_type,
    title text,
    description text,
    registration_label text,
    registration_link text,
    date_created datetime,
    date_modified datetime,
    ordering integer
);
CREATE TABLE pages (
    id integer NOT NULL,
    section text,
    component_id integer,
    images_collection_type text
);
CREATE TABLE pressaccounts (
    id integer NOT NULL,
    status pressaccount_status,
    firstname text,
    lastname text,
    media text,
    email text,
    password text,
    phone_number text,
    date_created datetime,
    date_modified datetime,
    notes text
);
CREATE TABLE pressaccounts_pressdocuments (
    pressaccount_id integer NOT NULL,
    pressdocument_id integer NOT NULL
);
CREATE TABLE pressdocumentfiles (
    id integer NOT NULL,
    pressdocument_id integer,
    status pressdocumentfile_status,
    title text,
    excerpt text,
    original_file_name varchar(255),
    date_created datetime,
    date_modified datetime,
    ordering integer
);
CREATE TABLE pressdocumentimages (
    id integer NOT NULL,
    pressdocument_id integer,
    status pressdocumentimage_status,
    title text,
    excerpt text,
    original_file_name varchar(255),
    date_created datetime,
    date_modified datetime,
    ordering integer
);
CREATE TABLE pressdocuments (
    id integer NOT NULL,
    status pressdocument_status,
    exhibition_id integer,
    title text,
    description text,
    extension text,
    date_created datetime,
    date_modified datetime,
    alternate_title text
);
CREATE TABLE programactivities (
    id integer NOT NULL,
    program_id integer,
    status programactivity_status,
    title text,
    description text(5000),
    date_created datetime,
    date_modified datetime,
    registration_link text,
    excerpt text(5000),
    ordering integer
);
CREATE TABLE programactivitydates (
    id integer NOT NULL,
    program_id integer,
    programactivity_id integer,
    status programactivitydate_status,
    date_start date,
    date_end date,
    date_copy text,
    date_created datetime,
    date_modified datetime,
    day_of_week text(3)
);
CREATE TABLE programcategories (
    id integer NOT NULL,
    status programcategory_status,
    ptype program_type,
    title text,
    description text,
    date_created datetime,
    date_modified datetime,
    show_all_filter boolean,
    ordering integer
);
CREATE TABLE programs (
    id integer NOT NULL,
    status program_status,
    ptype program_type,
    title text,
    grade text,
    content text,
    excerpt text,
    cost text,
    "time" text,
    before_and_after text,
    location text,
    what_to_bring text,
    cancellation_policy text,
    become_a_member text,
    supporters text,
    sponsors text,
    date_created datetime,
    date_modified datetime,
    lang text,
    overall_date_copy text,
    sidenote_title text,
    sidenote_content text,
    ordering integer,
    interface_lang program_interface_lang,
    alternate_title text,
    content_details text
);
CREATE TABLE programs_exhibitions (
    program_id integer NOT NULL,
    exhibition_id integer NOT NULL
);
CREATE TABLE programs_programcategories (
    program_id integer NOT NULL,
    programcategory_id integer NOT NULL
);
CREATE TABLE programs_programsubcategories (
    program_id integer NOT NULL,
    programsubcategory_id integer NOT NULL
);
CREATE TABLE programsubcategories (
    id integer NOT NULL,
    category_id integer,
    status programsubcategory_status,
    title text,
    description text,
    date_created datetime,
    date_modified datetime
);
CREATE TABLE shopcategories (
    id integer NOT NULL,
    status shopcategory_status,
    title text,
    description text,
    date_created datetime,
    date_modified datetime
);
CREATE TABLE shopitems (
    id integer NOT NULL,
    status shopitem_status,
    title text,
    sub_title text,
    excerpt text,
    content text,
    pricing text,
    date_created datetime,
    date_modified datetime,
    buy_link text,
    promote_on_home boolean,
    ordering integer,
    alternate_title text
);
CREATE TABLE shopitems_artists (
    shopitem_id integer NOT NULL,
    artist_id integer NOT NULL
);
CREATE TABLE shopitems_shopcategories (
    shopitem_id integer,
    shopcategory_id integer
);
CREATE TABLE shopitems_shopitems (
    shopitem_id integer NOT NULL,
    related_shopitem_id integer NOT NULL
);
CREATE TABLE showcases (
    id integer NOT NULL,
    date_modified datetime,
    ordering integer,
    active integer
);
CREATE TABLE showcases_collectionitems (
    showcase_id integer NOT NULL,
    collectionitem_id integer NOT NULL
);
CREATE TABLE showcases_educations (
    showcase_id integer NOT NULL,
    educationitem_id integer NOT NULL
);
CREATE TABLE showcases_events (
    showcase_id integer NOT NULL,
    event_id integer NOT NULL
);
CREATE TABLE showcases_exhibitions (
    showcase_id integer NOT NULL,
    exhibition_id integer NOT NULL
);
CREATE TABLE showcases_programs (
    showcase_id integer NOT NULL,
    program_id integer NOT NULL
);
CREATE TABLE showcases_shopitems (
    showcase_id integer NOT NULL,
    shopitem_id integer NOT NULL
);
CREATE TABLE staffmembers (
    id integer NOT NULL,
    status staffmember_status,
    stype staffmember_type,
    firstname text,
    lastname text,
    jobtitle text,
    department text,
    date_created datetime,
    date_modified datetime,
    ordering integer,
    phone_number text,
    fax_number text,
    email text,
    show_in_contact boolean
);
CREATE TABLE translations (
    hash varchar(255) NOT NULL,
    original text,
    en text,
    fr text
);
CREATE TABLE users (
    id integer NOT NULL,
    firstname varchar(255),
    lastname varchar(255),
    email varchar(255),
    phone varchar(255),
    hash varchar(255),
    salt varchar(255),
    login_timestamp datetime,
    role varchar(255),
    status text(20),
    password text(20)
);
CREATE TABLE videos (
    id integer NOT NULL,
    link_id integer,
    host text(200),
    embed_code text(5000),
    title_fr text(500),
    title_en text(500),
    description_fr text(5000),
    description_en text(5000)
);
ALTER TABLE ONLY archivefiles ALTER COLUMN id SET DEFAULT nextval('archivefiles_id_seq'::regclass);
ALTER TABLE ONLY archiveimages ALTER COLUMN id SET DEFAULT nextval('archiveimages_id_seq'::regclass);
ALTER TABLE ONLY archives ALTER COLUMN id SET DEFAULT nextval('archives_id_seq'::regclass);
ALTER TABLE ONLY artists ALTER COLUMN id SET DEFAULT nextval('artists_id_seq'::regclass);
ALTER TABLE ONLY collectionitems ALTER COLUMN id SET DEFAULT nextval('collectionitems_id_seq'::regclass);
ALTER TABLE ONLY collectionmedia ALTER COLUMN id SET DEFAULT nextval('collectionmedia_id_seq'::regclass);
ALTER TABLE ONLY educationcategories ALTER COLUMN id SET DEFAULT nextval('educationcategories_id_seq'::regclass);
ALTER TABLE ONLY educationitems ALTER COLUMN id SET DEFAULT nextval('educationitems_id_seq'::regclass);
ALTER TABLE ONLY educations ALTER COLUMN id SET DEFAULT nextval('educations_id_seq'::regclass);
ALTER TABLE ONLY educationsubcategories ALTER COLUMN id SET DEFAULT nextval('educationsubcategories_id_seq'::regclass);
ALTER TABLE ONLY eventcategories ALTER COLUMN id SET DEFAULT nextval('eventcategories_id_seq'::regclass);
ALTER TABLE ONLY events ALTER COLUMN id SET DEFAULT nextval('events_id_seq'::regclass);
ALTER TABLE ONLY exhibitions ALTER COLUMN id SET DEFAULT nextval('exhibitions_id_seq'::regclass);
ALTER TABLE ONLY links ALTER COLUMN id SET DEFAULT nextval('links_id_seq'::regclass);
ALTER TABLE ONLY memberships ALTER COLUMN id SET DEFAULT nextval('memberships_id_seq'::regclass);
ALTER TABLE ONLY pressaccounts ALTER COLUMN id SET DEFAULT nextval('pressaccounts_id_seq'::regclass);
ALTER TABLE ONLY pressdocumentfiles ALTER COLUMN id SET DEFAULT nextval('pressdocumentfiles_id_seq'::regclass);
ALTER TABLE ONLY pressdocumentimages ALTER COLUMN id SET DEFAULT nextval('pressdocumentimages_id_seq'::regclass);
ALTER TABLE ONLY pressdocuments ALTER COLUMN id SET DEFAULT nextval('pressdocuments_id_seq'::regclass);
ALTER TABLE ONLY programactivities ALTER COLUMN id SET DEFAULT nextval('programactivities_id_seq'::regclass);
ALTER TABLE ONLY programactivitydates ALTER COLUMN id SET DEFAULT nextval('programactivitydates_id_seq'::regclass);
ALTER TABLE ONLY programcategories ALTER COLUMN id SET DEFAULT nextval('programcategories_id_seq'::regclass);
ALTER TABLE ONLY programs ALTER COLUMN id SET DEFAULT nextval('programs_id_seq'::regclass);
ALTER TABLE ONLY programsubcategories ALTER COLUMN id SET DEFAULT nextval('programsubcategories_id_seq'::regclass);
ALTER TABLE ONLY shopcategories ALTER COLUMN id SET DEFAULT nextval('shopcategories_id_seq'::regclass);
ALTER TABLE ONLY shopitems ALTER COLUMN id SET DEFAULT nextval('shopitems_id_seq'::regclass);
ALTER TABLE ONLY showcases ALTER COLUMN id SET DEFAULT nextval('showcases_id_seq'::regclass);
ALTER TABLE ONLY staffmembers ALTER COLUMN id SET DEFAULT nextval('staffmembers_id_seq'::regclass);
ALTER TABLE ONLY videos ALTER COLUMN id SET DEFAULT nextval('videos_id_seq'::regclass);
ALTER TABLE ONLY archivefiles
    ADD CONSTRAINT archivefiles_pkey PRIMARY KEY (id);
ALTER TABLE ONLY archiveimages
    ADD CONSTRAINT archiveimages_pkey PRIMARY KEY (id);
ALTER TABLE ONLY archives_artists
    ADD CONSTRAINT archives_artists_pkey PRIMARY KEY (archive_id, artist_id);
ALTER TABLE ONLY archives
    ADD CONSTRAINT archives_pkey PRIMARY KEY (id);
ALTER TABLE ONLY artists
    ADD CONSTRAINT artists_pkey PRIMARY KEY (id);
ALTER TABLE ONLY collectionitems_artists
    ADD CONSTRAINT collectionitems_artists_pkey PRIMARY KEY (collectionitem_id, artist_id);
ALTER TABLE ONLY collectionitems_collectionmedia
    ADD CONSTRAINT collectionitems_collectionmedia_pkey PRIMARY KEY (collectionitem_id, collectionmedium_id);
ALTER TABLE ONLY collectionitems
    ADD CONSTRAINT collectionitems_pkey PRIMARY KEY (id);
ALTER TABLE ONLY collectionmedia
    ADD CONSTRAINT collectionmedia_pkey PRIMARY KEY (id);
ALTER TABLE ONLY collections
    ADD CONSTRAINT collections_pkey PRIMARY KEY (id);
ALTER TABLE ONLY contents
    ADD CONSTRAINT contents_pkey PRIMARY KEY (key_hash);
ALTER TABLE ONLY educationcategories
    ADD CONSTRAINT educationcategories_pkey PRIMARY KEY (id);
ALTER TABLE ONLY educationitems
    ADD CONSTRAINT educationitems_pkey PRIMARY KEY (id);
ALTER TABLE ONLY educations_educationcategories
    ADD CONSTRAINT educations_educationcategories_pkey PRIMARY KEY (education_id, educationcategory_id);
ALTER TABLE ONLY educations_educationitems
    ADD CONSTRAINT educations_educationitems_pkey PRIMARY KEY (education_id, educationitem_id);
ALTER TABLE ONLY educations_educationsubcategories
    ADD CONSTRAINT educations_educationsubcategories_pkey PRIMARY KEY (education_id, educationsubcategory_id);
ALTER TABLE ONLY educations
    ADD CONSTRAINT educations_pkey PRIMARY KEY (id);
ALTER TABLE ONLY educationsubcategories
    ADD CONSTRAINT educationsubcategories_pkey PRIMARY KEY (id);
ALTER TABLE ONLY eventcategories
    ADD CONSTRAINT eventcategories_pkey PRIMARY KEY (id);
ALTER TABLE ONLY events_eventcategories
    ADD CONSTRAINT events_eventcategories_pkey PRIMARY KEY (event_id, eventcategory_id);
ALTER TABLE ONLY events_exhibitions
    ADD CONSTRAINT events_exhibitions_pkey PRIMARY KEY (event_id, exhibition_id);
ALTER TABLE ONLY events
    ADD CONSTRAINT events_pkey PRIMARY KEY (id);
ALTER TABLE ONLY events_shopitems
    ADD CONSTRAINT events_shopitems_pkey PRIMARY KEY (event_id, shopitem_id);
ALTER TABLE ONLY exhibitions_artists
    ADD CONSTRAINT exhibitions_artists_pkey PRIMARY KEY (exhibition_id, artist_id);
ALTER TABLE ONLY exhibitions_exhibitions
    ADD CONSTRAINT exhibitions_exhibitions_pkey PRIMARY KEY (exhibition_id, related_exhibition_id);
ALTER TABLE ONLY exhibitions
    ADD CONSTRAINT exhibitions_pkey PRIMARY KEY (id);
ALTER TABLE ONLY exhibitions_shopitems
    ADD CONSTRAINT exhibitions_shopitems_pkey PRIMARY KEY (exhibition_id, shopitem_id);
ALTER TABLE ONLY image_uploads
    ADD CONSTRAINT image_uploads_pkey PRIMARY KEY (id);
ALTER TABLE ONLY images
    ADD CONSTRAINT images_pkey PRIMARY KEY (id);
ALTER TABLE ONLY links
    ADD CONSTRAINT links_pkey PRIMARY KEY (id);
ALTER TABLE ONLY memberships
    ADD CONSTRAINT memberships_pkey PRIMARY KEY (id);
ALTER TABLE ONLY pages
    ADD CONSTRAINT pages_pkey PRIMARY KEY (id);
ALTER TABLE ONLY pressaccounts
    ADD CONSTRAINT pressaccounts_pkey PRIMARY KEY (id);
ALTER TABLE ONLY pressaccounts_pressdocuments
    ADD CONSTRAINT pressaccounts_pressdocuments_pkey PRIMARY KEY (pressaccount_id, pressdocument_id);
ALTER TABLE ONLY pressdocumentfiles
    ADD CONSTRAINT pressdocumentfiles_pkey PRIMARY KEY (id);
ALTER TABLE ONLY pressdocumentimages
    ADD CONSTRAINT pressdocumentimages_pkey PRIMARY KEY (id);
ALTER TABLE ONLY pressdocuments
    ADD CONSTRAINT pressdocuments_pkey PRIMARY KEY (id);
ALTER TABLE ONLY programactivities
    ADD CONSTRAINT programactivities_pkey PRIMARY KEY (id);
ALTER TABLE ONLY programactivitydates
    ADD CONSTRAINT programactivitydates_pkey PRIMARY KEY (id);
ALTER TABLE ONLY programcategories
    ADD CONSTRAINT programcategories_pkey PRIMARY KEY (id);
ALTER TABLE ONLY programs_exhibitions
    ADD CONSTRAINT programs_exhibitions_pkey PRIMARY KEY (program_id, exhibition_id);
ALTER TABLE ONLY programs
    ADD CONSTRAINT programs_pkey PRIMARY KEY (id);
ALTER TABLE ONLY programs_programcategories
    ADD CONSTRAINT programs_programcategories_pkey PRIMARY KEY (program_id, programcategory_id);
ALTER TABLE ONLY programs_programsubcategories
    ADD CONSTRAINT programs_programsubcategories_pkey PRIMARY KEY (program_id, programsubcategory_id);
ALTER TABLE ONLY programsubcategories
    ADD CONSTRAINT programsubcategories_pkey PRIMARY KEY (id);
ALTER TABLE ONLY shopcategories
    ADD CONSTRAINT shopcategories_pkey PRIMARY KEY (id);
ALTER TABLE ONLY shopitems_artists
    ADD CONSTRAINT shopitems_artists_pkey PRIMARY KEY (shopitem_id, artist_id);
ALTER TABLE ONLY shopitems
    ADD CONSTRAINT shopitems_pkey PRIMARY KEY (id);
ALTER TABLE ONLY shopitems_shopitems
    ADD CONSTRAINT shopitems_shopitems_pkey PRIMARY KEY (shopitem_id, related_shopitem_id);
ALTER TABLE ONLY showcases_collectionitems
    ADD CONSTRAINT showcases_collectionitems_pkey PRIMARY KEY (showcase_id, collectionitem_id);
ALTER TABLE ONLY showcases_educations
    ADD CONSTRAINT showcases_educations_pkey PRIMARY KEY (showcase_id, educationitem_id);
ALTER TABLE ONLY showcases_events
    ADD CONSTRAINT showcases_events_pkey PRIMARY KEY (showcase_id, event_id);
ALTER TABLE ONLY showcases_exhibitions
    ADD CONSTRAINT showcases_exhibitions_pkey PRIMARY KEY (showcase_id, exhibition_id);
ALTER TABLE ONLY showcases
    ADD CONSTRAINT showcases_pkey PRIMARY KEY (id);
ALTER TABLE ONLY showcases_programs
    ADD CONSTRAINT showcases_programs_pkey PRIMARY KEY (showcase_id, program_id);
ALTER TABLE ONLY showcases_shopitems
    ADD CONSTRAINT showcases_shopitems_pkey PRIMARY KEY (showcase_id, shopitem_id);
ALTER TABLE ONLY staffmembers
    ADD CONSTRAINT staffmembers_pkey PRIMARY KEY (id);
ALTER TABLE ONLY translations
    ADD CONSTRAINT translations_original_key UNIQUE (original);
ALTER TABLE ONLY translations
    ADD CONSTRAINT translations_pkey PRIMARY KEY (hash);
ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
ALTER TABLE ONLY videos
    ADD CONSTRAINT videos_pkey PRIMARY KEY (id);
ALTER TABLE ONLY archivefiles
    ADD CONSTRAINT archivefiles_archive_id_fkey FOREIGN KEY (archive_id) REFERENCES archives(id);
ALTER TABLE ONLY archiveimages
    ADD CONSTRAINT archiveimages_archive_id_fkey FOREIGN KEY (archive_id) REFERENCES archives(id);
ALTER TABLE ONLY archives_artists
    ADD CONSTRAINT archives_artists_archive_id_fkey FOREIGN KEY (archive_id) REFERENCES archives(id);
ALTER TABLE ONLY archives_artists
    ADD CONSTRAINT archives_artists_artist_id_fkey FOREIGN KEY (artist_id) REFERENCES artists(id);
ALTER TABLE ONLY archives
    ADD CONSTRAINT archives_exhibition_id_fkey FOREIGN KEY (exhibition_id) REFERENCES exhibitions(id);
ALTER TABLE ONLY collectionitems_artists
    ADD CONSTRAINT collectionitems_artists_artist_id_fkey FOREIGN KEY (artist_id) REFERENCES artists(id);
ALTER TABLE ONLY collectionitems_artists
    ADD CONSTRAINT collectionitems_artists_collectionitem_id_fkey FOREIGN KEY (collectionitem_id) REFERENCES collectionitems(id);
ALTER TABLE ONLY collectionitems_collectionmedia
    ADD CONSTRAINT collectionitems_collectionmedia_collectionitem_id_fkey FOREIGN KEY (collectionitem_id) REFERENCES collectionitems(id);
ALTER TABLE ONLY collectionitems_collectionmedia
    ADD CONSTRAINT collectionitems_collectionmedia_collectionmedium_id_fkey FOREIGN KEY (collectionmedium_id) REFERENCES collectionmedia(id);
ALTER TABLE ONLY collections
    ADD CONSTRAINT collections_id_fkey FOREIGN KEY (id) REFERENCES links(id);
ALTER TABLE ONLY collections
    ADD CONSTRAINT collections_link_id_fkey FOREIGN KEY (link_id) REFERENCES links(id);
ALTER TABLE ONLY educations_educationcategories
    ADD CONSTRAINT educations_educationcategories_education_id_fkey FOREIGN KEY (education_id) REFERENCES educations(id);
ALTER TABLE ONLY educations_educationcategories
    ADD CONSTRAINT educations_educationcategories_educationcategory_id_fkey FOREIGN KEY (educationcategory_id) REFERENCES educationcategories(id);
ALTER TABLE ONLY educations_educationitems
    ADD CONSTRAINT educations_educationitems_education_id_fkey FOREIGN KEY (education_id) REFERENCES educations(id);
ALTER TABLE ONLY educations_educationitems
    ADD CONSTRAINT educations_educationitems_educationitem_id_fkey FOREIGN KEY (educationitem_id) REFERENCES educationitems(id);
ALTER TABLE ONLY educations_educationsubcategories
    ADD CONSTRAINT educations_educationsubcategories_education_id_fkey FOREIGN KEY (education_id) REFERENCES educations(id);
ALTER TABLE ONLY educations_educationsubcategories
    ADD CONSTRAINT educations_educationsubcategories_educationsubcategory_id_fkey FOREIGN KEY (educationsubcategory_id) REFERENCES educationsubcategories(id);
ALTER TABLE ONLY educationsubcategories
    ADD CONSTRAINT educationsubcategories_category_id_fkey FOREIGN KEY (category_id) REFERENCES educationcategories(id);
ALTER TABLE ONLY events_eventcategories
    ADD CONSTRAINT events_eventcategories_event_id_fkey FOREIGN KEY (event_id) REFERENCES events(id);
ALTER TABLE ONLY events_eventcategories
    ADD CONSTRAINT events_eventcategories_eventcategory_id_fkey FOREIGN KEY (eventcategory_id) REFERENCES eventcategories(id);
ALTER TABLE ONLY events_exhibitions
    ADD CONSTRAINT events_exhibitions_event_id_fkey FOREIGN KEY (event_id) REFERENCES events(id);
ALTER TABLE ONLY events_exhibitions
    ADD CONSTRAINT events_exhibitions_exhibition_id_fkey FOREIGN KEY (exhibition_id) REFERENCES exhibitions(id);
ALTER TABLE ONLY events_shopitems
    ADD CONSTRAINT events_shopitems_event_id_fkey FOREIGN KEY (event_id) REFERENCES events(id);
ALTER TABLE ONLY events_shopitems
    ADD CONSTRAINT events_shopitems_shopitem_id_fkey FOREIGN KEY (shopitem_id) REFERENCES shopitems(id);
ALTER TABLE ONLY exhibitions_artists
    ADD CONSTRAINT exhibitions_artists_artist_id_fkey FOREIGN KEY (artist_id) REFERENCES artists(id);
ALTER TABLE ONLY exhibitions_artists
    ADD CONSTRAINT exhibitions_artists_exhibition_id_fkey FOREIGN KEY (exhibition_id) REFERENCES exhibitions(id);
ALTER TABLE ONLY exhibitions_exhibitions
    ADD CONSTRAINT exhibitions_exhibitions_exhibition_id_fkey FOREIGN KEY (exhibition_id) REFERENCES exhibitions(id);
ALTER TABLE ONLY exhibitions_exhibitions
    ADD CONSTRAINT exhibitions_exhibitions_related_exhibition_id_fkey FOREIGN KEY (related_exhibition_id) REFERENCES exhibitions(id);
ALTER TABLE ONLY exhibitions_shopitems
    ADD CONSTRAINT exhibitions_shopitems_exhibition_id_fkey FOREIGN KEY (exhibition_id) REFERENCES exhibitions(id);
ALTER TABLE ONLY exhibitions_shopitems
    ADD CONSTRAINT exhibitions_shopitems_shopitem_id_fkey FOREIGN KEY (shopitem_id) REFERENCES shopitems(id);
ALTER TABLE ONLY image_uploads
    ADD CONSTRAINT image_uploads_link_id_fkey FOREIGN KEY (link_id) REFERENCES links(id);
ALTER TABLE ONLY images
    ADD CONSTRAINT images_image_upload_id_fkey FOREIGN KEY (image_upload_id) REFERENCES image_uploads(id);
ALTER TABLE ONLY images
    ADD CONSTRAINT images_link_id_fkey FOREIGN KEY (link_id) REFERENCES links(id);
ALTER TABLE ONLY pages
    ADD CONSTRAINT pages_id_fkey FOREIGN KEY (id) REFERENCES links(id);
ALTER TABLE ONLY pressaccounts_pressdocuments
    ADD CONSTRAINT pressaccounts_pressdocuments_pressaccount_id_fkey FOREIGN KEY (pressaccount_id) REFERENCES pressaccounts(id);
ALTER TABLE ONLY pressaccounts_pressdocuments
    ADD CONSTRAINT pressaccounts_pressdocuments_pressdocument_id_fkey FOREIGN KEY (pressdocument_id) REFERENCES pressdocuments(id);
ALTER TABLE ONLY pressdocumentfiles
    ADD CONSTRAINT pressdocumentfiles_pressdocument_id_fkey FOREIGN KEY (pressdocument_id) REFERENCES pressdocuments(id);
ALTER TABLE ONLY pressdocumentimages
    ADD CONSTRAINT pressdocumentimages_pressdocument_id_fkey FOREIGN KEY (pressdocument_id) REFERENCES pressdocuments(id);
ALTER TABLE ONLY pressdocuments
    ADD CONSTRAINT pressdocuments_exhibition_id_fkey FOREIGN KEY (exhibition_id) REFERENCES exhibitions(id);
ALTER TABLE ONLY programactivities
    ADD CONSTRAINT programactivities_program_id_fkey FOREIGN KEY (program_id) REFERENCES programs(id);
ALTER TABLE ONLY programactivitydates
    ADD CONSTRAINT programactivitydates_program_id_fkey FOREIGN KEY (program_id) REFERENCES programs(id);
ALTER TABLE ONLY programactivitydates
    ADD CONSTRAINT programactivitydates_programactivity_id_fkey FOREIGN KEY (programactivity_id) REFERENCES programactivities(id);
ALTER TABLE ONLY programs_exhibitions
    ADD CONSTRAINT programs_exhibitions_exhibition_id_fkey FOREIGN KEY (exhibition_id) REFERENCES exhibitions(id);
ALTER TABLE ONLY programs_exhibitions
    ADD CONSTRAINT programs_exhibitions_program_id_fkey FOREIGN KEY (program_id) REFERENCES programs(id);
ALTER TABLE ONLY programs_programcategories
    ADD CONSTRAINT programs_programcategories_program_id_fkey FOREIGN KEY (program_id) REFERENCES programs(id);
ALTER TABLE ONLY programs_programcategories
    ADD CONSTRAINT programs_programcategories_programcategory_id_fkey FOREIGN KEY (programcategory_id) REFERENCES programcategories(id);
ALTER TABLE ONLY programs_programsubcategories
    ADD CONSTRAINT programs_programsubcategories_program_id_fkey FOREIGN KEY (program_id) REFERENCES programs(id);
ALTER TABLE ONLY programs_programsubcategories
    ADD CONSTRAINT programs_programsubcategories_programsubcategory_id_fkey FOREIGN KEY (programsubcategory_id) REFERENCES programsubcategories(id);
ALTER TABLE ONLY programsubcategories
    ADD CONSTRAINT programsubcategories_category_id_fkey FOREIGN KEY (category_id) REFERENCES programcategories(id);
ALTER TABLE ONLY shopitems_artists
    ADD CONSTRAINT shopitems_artists_shopitem_id_fkey FOREIGN KEY (shopitem_id) REFERENCES shopitems(id);
ALTER TABLE ONLY shopitems_shopcategories
    ADD CONSTRAINT shopitems_shopcategories_shopcategory_id_fkey FOREIGN KEY (shopcategory_id) REFERENCES shopcategories(id);
ALTER TABLE ONLY shopitems_shopcategories
    ADD CONSTRAINT shopitems_shopcategories_shopitem_id_fkey FOREIGN KEY (shopitem_id) REFERENCES shopitems(id);
ALTER TABLE ONLY shopitems_shopitems
    ADD CONSTRAINT shopitems_shopitems_related_shopitem_id_fkey FOREIGN KEY (related_shopitem_id) REFERENCES shopitems(id);
ALTER TABLE ONLY shopitems_shopitems
    ADD CONSTRAINT shopitems_shopitems_shopitem_id_fkey FOREIGN KEY (shopitem_id) REFERENCES shopitems(id);
ALTER TABLE ONLY showcases_collectionitems
    ADD CONSTRAINT showcases_collectionitems_collectionitem_id_fkey FOREIGN KEY (collectionitem_id) REFERENCES collectionitems(id);
ALTER TABLE ONLY showcases_collectionitems
    ADD CONSTRAINT showcases_collectionitems_showcase_id_fkey FOREIGN KEY (showcase_id) REFERENCES showcases(id);
ALTER TABLE ONLY showcases_educations
    ADD CONSTRAINT showcases_educations_educationitem_id_fkey FOREIGN KEY (educationitem_id) REFERENCES educations(id);
ALTER TABLE ONLY showcases_educations
    ADD CONSTRAINT showcases_educations_showcase_id_fkey FOREIGN KEY (showcase_id) REFERENCES showcases(id);
ALTER TABLE ONLY showcases_events
    ADD CONSTRAINT showcases_events_event_id_fkey FOREIGN KEY (event_id) REFERENCES events(id);
ALTER TABLE ONLY showcases_events
    ADD CONSTRAINT showcases_events_showcase_id_fkey FOREIGN KEY (showcase_id) REFERENCES showcases(id);
ALTER TABLE ONLY showcases_exhibitions
    ADD CONSTRAINT showcases_exhibitions_exhibition_id_fkey FOREIGN KEY (exhibition_id) REFERENCES exhibitions(id);
ALTER TABLE ONLY showcases_exhibitions
    ADD CONSTRAINT showcases_exhibitions_showcase_id_fkey FOREIGN KEY (showcase_id) REFERENCES showcases(id);
ALTER TABLE ONLY showcases_programs
    ADD CONSTRAINT showcases_programs_program_id_fkey FOREIGN KEY (program_id) REFERENCES programs(id);
ALTER TABLE ONLY showcases_programs
    ADD CONSTRAINT showcases_programs_showcase_id_fkey FOREIGN KEY (showcase_id) REFERENCES showcases(id);
ALTER TABLE ONLY showcases_shopitems
    ADD CONSTRAINT showcases_shopitems_shopitem_id_fkey FOREIGN KEY (shopitem_id) REFERENCES shopitems(id);
ALTER TABLE ONLY showcases_shopitems
    ADD CONSTRAINT showcases_shopitems_showcase_id_fkey FOREIGN KEY (showcase_id) REFERENCES showcases(id);
ALTER TABLE ONLY users
    ADD CONSTRAINT users_id_fkey FOREIGN KEY (id) REFERENCES links(id);
ALTER TABLE ONLY videos
    ADD CONSTRAINT videos_link_id_fkey FOREIGN KEY (link_id) REFERENCES links(id);