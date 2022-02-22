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
    tx_bootstrap_text_color varchar(48) DEFAULT '' NOT NULL,
    tx_bootstrap_background_color varchar(48) DEFAULT '' NOT NULL,
    tx_bootstrap_additional_styles varchar(1048) DEFAULT '' NOT NULL,
    tx_bootstrap_inner_frame_class varchar(48) DEFAULT '' NOT NULL,
    tx_bootstrap_flexform mediumtext,
    tx_bootstrap_image1 int(11) DEFAULT '0' NOT NULL,
    tx_bootstrap_image2 int(11) DEFAULT '0' NOT NULL,
    tx_bootstrap_bodytext1 text,
    tx_bootstrap_bodytext2 text,
    tx_bootstrap_teammember int(11) DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_bootstrap_domain_model_item'
#
CREATE TABLE tx_bootstrap_domain_model_item (
    title varchar(255) DEFAULT '' NOT NULL,
    subtitle varchar(255) DEFAULT '' NOT NULL,
    typolink varchar(1048) DEFAULT '' NOT NULL,
    image int(11) DEFAULT '0' NOT NULL,
    description text,
);

#
# Table structure for table 'tx_bootstrap_domain_model_teammember'
#
CREATE TABLE tx_bootstrap_domain_model_teammember (
    name varchar(255) DEFAULT '' NOT NULL,
    portrait int(11) DEFAULT '0' NOT NULL,
    description text,
    tt_content_uid int(11) DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'sys_file_reference'
#
CREATE TABLE sys_file_reference (
    tx_bootstrap_header varchar(255) DEFAULT '' NOT NULL,
    tx_bootstrap_link_text varchar(255) DEFAULT '' NOT NULL,
);
