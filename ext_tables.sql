#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
    table_class varchar(255) DEFAULT '' NOT NULL,
    tx_bootstrap_header_layout varchar(48) DEFAULT '' NOT NULL,
    tx_bootstrap_header_color varchar(48) DEFAULT '' NOT NULL,
    tx_bootstrap_header_predefined varchar(48) DEFAULT '' NOT NULL,
    tx_bootstrap_header_additional_styles varchar(48) DEFAULT '' NOT NULL,
    tx_bootstrap_header_icon int(11) unsigned NOT NULL default '0',
    tx_bootstrap_header_iconset varchar(128) DEFAULT '' NOT NULL,
    tx_bootstrap_text_color varchar(48) DEFAULT '' NOT NULL,
    tx_bootstrap_background_color varchar(48) DEFAULT '' NOT NULL,
    tx_bootstrap_additional_styles varchar(1048) DEFAULT '' NOT NULL,
    tx_bootstrap_inner_frame_class varchar(48) DEFAULT '' NOT NULL,
    tx_bootstrap_flexform mediumtext,
    tx_bootstrap_image1 int(11) DEFAULT '0' NOT NULL,
    tx_bootstrap_image2 int(11) DEFAULT '0' NOT NULL,
    tx_bootstrap_bodytext1 text,
    tx_bootstrap_bodytext2 text,
    tx_bootstrap_accordionitems int(11) DEFAULT '0' NOT NULL,
    tx_bootstrap_tabulatoritems int(11) DEFAULT '0' NOT NULL,
    tx_bootstrap_carditems int(11) DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'sys_file_reference'
#
CREATE TABLE sys_file_reference (
    tx_bootstrap_header varchar(255) DEFAULT '' NOT NULL,
    tx_bootstrap_link_text varchar(255) DEFAULT '' NOT NULL,
);

#
# Table structure for table 'tx_bootstrap_domain_model_accordionitem'
#
CREATE TABLE tx_bootstrap_domain_model_accordionitem (
    title varchar(255) DEFAULT '' NOT NULL,
    opened_on_load tinyint(1) unsigned NOT NULL default '0',
    content_elements int(11) DEFAULT '0' NOT NULL,
    tt_content_uid int(11) DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_bootstrap_domain_model_tabulatoritem'
#
CREATE TABLE tx_bootstrap_domain_model_tabulatoritem (
    title varchar(255) DEFAULT '' NOT NULL,
    active tinyint(1) unsigned NOT NULL default '0',
    content_elements int(11) DEFAULT '0' NOT NULL,
    tt_content_uid int(11) DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_bootstrap_domain_model_contentelement'
#
CREATE TABLE tx_bootstrap_domain_model_contentelement (
    header varchar(255) DEFAULT '' NOT NULL,
	header_position varchar(255) DEFAULT '' NOT NULL,
    header_layout varchar(30) DEFAULT '0' NOT NULL,
    header_link varchar(1024) DEFAULT '' NOT NULL,
    date int(10) unsigned DEFAULT '0' NOT NULL,
    subheader varchar(255) DEFAULT '' NOT NULL,
    bodytext mediumtext,
    assets int(11) unsigned DEFAULT '0' NOT NULL,
    space_before_class varchar(60) DEFAULT '' NOT NULL,
    space_after_class varchar(60) DEFAULT '' NOT NULL,
    tx_bootstrap_header_layout varchar(255) DEFAULT '' NOT NULL,
    tx_bootstrap_header_predefined varchar(255) DEFAULT '' NOT NULL,
    tx_bootstrap_header_color varchar(255) DEFAULT '' NOT NULL,
    tx_bootstrap_header_additional_styles varchar(255) DEFAULT '' NOT NULL,
    tx_bootstrap_header_icon int(11) DEFAULT '0' NOT NULL,
    tx_bootstrap_header_iconset varchar(128) DEFAULT '' NOT NULL,
    tx_bootstrap_flexform mediumtext,
    accordionitem_uid int(11) DEFAULT '0' NOT NULL,
    tabulatoritem_uid int(11) DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_bootstrap_domain_model_carditem'
#
CREATE TABLE tx_bootstrap_domain_model_carditem (
    header varchar(255) DEFAULT '' NOT NULL,
    title varchar(255) DEFAULT '' NOT NULL,
    image int(11) DEFAULT '0' NOT NULL,
    text text,
    typolink varchar(1048) DEFAULT '' NOT NULL,
    typolink_text varchar(255) DEFAULT '' NOT NULL,
    footer varchar(255) DEFAULT '' NOT NULL,
    tt_content_uid int(11) DEFAULT '0' NOT NULL,
);