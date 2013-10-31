<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @package		MODL Meta - Based on Seo_lite
 * @subpackage	ThirdParty
 * @category	Modules
 * @author 		bjorn (original - SEO Lite 1.3.4)
 * @author		Minds On Design Lab (Extended)
 * @link		https://github.com/Minds-On-Design-Lab/modl_meta.ee_addon - Extended from SEO Lite http://ee.bybjorn.com/seo_lite
 */

class Modl_meta_tab {

    public function __construct()
    {
        $this->EE =& get_instance();
        $this->EE->lang->loadfile('modl_meta');

        if($this->EE->config->item('modl_meta_tab_title')) {
            $this->EE->lang->language['modl_meta'] = $this->EE->config->item('modl_meta_tab_title');
        }
    }

    public function publish_tabs($channel_id, $entry_id = '')
    {
        $settings = array();

        $this->EE->cp->load_package_js('tab');

        $languages = array();
        $content = array('en' => array(
          'title' => '',
          'keywords' => '',
          'description' => '',
          'og_title' => '',
          'og_type' => '',
          'og_description' => '',
          'og_image' => '',
          'language' => ''
        ));

        if($entry_id)
        {
            $q = $this->EE->db->get_where('modl_meta_content', array('entry_id' => $entry_id));
            if($q->num_rows())
            {
              foreach( $q->result() as $row )
              {
                $content[$row->language] = array(
                  'title' => $row->title,
                  'keywords' => $row->keywords,
                  'description' => $row->description,
                  'og_title' => $row->og_title,
                  'og_type' => $row->og_type,
                  'og_description' => $row->og_description,
                  'og_image' => $row->og_image,
                  'language' => $row->language
                );
              }
            }
        }

        $site_id = $this->EE->config->item('site_id');
        $config = $this->EE->db->get_where('modl_meta_config', array('site_id' => $site_id));

        if($config->num_rows() == 0) // we did not find any config for this site id, so just load any other
        {
            $config = $this->EE->db->get_where('modl_meta_config');
        }

        $languages = json_decode($config->row('languages'), true);

        $settings[] = array(
           'field_id' => 'modl_media_lang_cc',
           'field_label' => lang('language'),
           'field_required' => 'n',
           'field_data' => 'en',
           'field_list_items' => $languages,
           'field_fmt' => '',
           'field_instructions' => lang('language_instructions'),
           'field_show_fmt' => 'n',
           'field_fmt_options' => array(),
           'field_pre_populate' => 'n',
           'field_type' => 'select',
        );

        foreach( $languages as $cc => $label ) {
          if( array_key_exists($cc, $content) )
          {
            $lang_content = $content[$cc];
          }
          else
          {
            $lang_content = $content['en'];
          }

          $settings[] = array(
             'field_id' => 'modl_meta_title_'.$cc,
             'field_label' => lang('seotitle').' - '.$label,
             'field_required' => 'n',
             'field_data' => $lang_content['title'],
             'field_list_items' => '',
             'field_fmt' => '',
             'field_instructions' => lang('title_instructions'),
             'field_show_fmt' => 'n',
             'field_fmt_options' => array(),
             'field_pre_populate' => 'n',
             'field_text_direction' => 'ltr',
             'field_type' => 'text',
             'field_maxl' => '1024'
          );

          $settings[] = array(
             'field_id' => 'modl_meta_keywords_'.$cc,
             'field_label' => lang('seokeywords').' - '.$label,
             'field_required' => 'n',
             'field_data' => $lang_content['keywords'],
             'field_list_items' => '',
             'field_fmt' => '',
             'field_instructions' => lang('keywords_instructions'),
             'field_show_fmt' => 'n',
             'field_fmt_options' => array(),
             'field_pre_populate' => 'n',
             'field_text_direction' => 'ltr',
              'field_type' => 'textarea',
              'field_ta_rows'      => 5,
          );

          $settings[] = array(
             'field_id' => 'modl_meta_description_'.$cc,
             'field_label' => lang('seodescription').' - '.$label,
             'field_required' => 'n',
             'field_data' => $lang_content['description'],
             'field_list_items' => '',
             'field_fmt' => '',
             'field_instructions' => lang('description_instructions'),
             'field_show_fmt' => 'n',
             'field_fmt_options' => array(),
             'field_pre_populate' => 'n',
             'field_text_direction' => 'ltr',
             'field_type' => 'textarea',
             'field_ta_rows'       => 5,

         );
        }

       // MODL Meta - Open Graph

        $settings[] = array(
           'field_id' => 'modl_meta_og_title',
           'field_label' => lang('og_title'),
           'field_required' => 'n',
           'field_data' => $content['en']['og_title'],
           'field_list_items' => '',
           'field_fmt' => '',
           'field_instructions' => lang('og_title_instructions'),
           'field_show_fmt' => 'n',
           'field_fmt_options' => array(),
           'field_pre_populate' => 'n',
           'field_text_direction' => 'ltr',
           'field_type' => 'text',
           'field_maxl' => '1024'
        );

        $settings[] = array(
           'field_id' => 'modl_meta_og_type',
           'field_label' => lang('og_type'),
           'field_required' => 'n',
           'field_data' => $content['en']['og_type'],
           'field_list_items' => array(
           		'' => '-- Select Type --',
           		'article' => 'Article',
           		'profile' => 'Profile',
           		'video' => 'Video',
           		'music' => 'Music',
           ),
           'field_fmt' => '',
           'field_instructions' => lang('og_type_instructions'),
           'field_show_fmt' => 'n',
           'field_fmt_options' => array(),
           'field_pre_populate' => 'n',
           'field_text_direction' => 'ltr',
           'field_type' => 'select',

       );


       $settings[] = array(
           'field_id' => 'modl_meta_og_description',
           'field_label' => lang('og_description'),
           'field_required' => 'n',
           'field_data' => $content['en']['og_description'],
           'field_list_items' => '',
           'field_fmt' => '',
           'field_instructions' => lang('og_description_instructions'),
           'field_show_fmt' => 'n',
           'field_fmt_options' => array(),
           'field_pre_populate' => 'n',
           'field_text_direction' => 'ltr',
           'field_type' => 'textarea',
           'field_ta_rows'		   => 5,

       );

        $settings[] = array(
           'field_id' => 'modl_meta_og_image',
           'field_label' => lang('og_image'),
           'field_required' => 'n',
           'field_data' => $content['en']['og_image'],
           'field_list_items' => '',
           'field_fmt' => '',
           'field_instructions' => lang('og_image_instructions'),
           'field_show_fmt' => 'n',
           'field_fmt_options' => array(),
           'field_pre_populate' => 'n',
           'field_text_direction' => 'ltr',
           'field_type' => 'file',

       );

        return $settings;
    }

    function validate_publish($params)
    {
        return TRUE;
    }

    /**
     * Save the data to the db
     *
     * @param  $params
     * @return void
     */
    function publish_data_db($params)
    {
        $entry_data = $params['data']; // get full entry data posted
        $modl_meta_data = $params['mod_data']; // get module related entry data posted
        $site_id = $params['meta']['site_id'];
        $entry_id = $params['entry_id'];
        if($modl_meta_data['modl_meta_og_image']) // check if an image was selected and build with directory id
        {
          //check EE version to see if we need to append the filedir, or if EE will do it automagically
          if ($this->EE->config->item('app_version') < '250') {
            $og_image = '{filedir_'.$entry_data['modl_meta__modl_meta_og_image_directory'].'}'.$modl_meta_data['modl_meta_og_image'];
          } else {
            $og_image = $modl_meta_data['modl_meta_og_image'];
          }
        } else {
          $og_image = '';
        }

        $site_id = $this->EE->config->item('site_id');
        $config = $this->EE->db->get_where('modl_meta_config', array('site_id' => $site_id));

        if($config->num_rows() == 0) // we did not find any config for this site id, so just load any other
        {
            $config = $this->EE->db->get_where('modl_meta_config');
        }

        $languages = json_decode($config->row('languages'), true);

        foreach( $languages as $cc => $label ) {
          $content = array(
              'site_id' => $site_id,
              'entry_id' => $entry_id,
              'title' => $modl_meta_data['modl_meta_title_'.$cc],
              'keywords' => $modl_meta_data['modl_meta_keywords_'.$cc],
              'description' => $modl_meta_data['modl_meta_description_'.$cc],
              'language' => $cc
          );

          if( $cc == 'en' ) {
            $content = array_merge($content, array(
                'og_title' => $modl_meta_data['modl_meta_og_title'],
                'og_type' => $modl_meta_data['modl_meta_og_type'],
                'og_description' => $modl_meta_data['modl_meta_og_description'],
                'og_image' => $og_image,
            ));
          }

          $q = $this->EE->db->get_where('modl_meta_content', array('site_id' => $site_id, 'entry_id' => $entry_id, 'language' => $cc));
          if($q->num_rows())
          {
              $this->EE->db->where('entry_id', $entry_id);
              $this->EE->db->where('site_id', $site_id);
              $this->EE->db->where('language', $cc);
              $this->EE->db->update('modl_meta_content', $content);
          }
          else
          {
              $this->EE->db->insert('modl_meta_content', $content);
          }

        }
    }

    /**
     * Delete seo data if entry is deleted
     *
     * @param  $params
     * @return void
     */
    function publish_data_delete_db($params)
    {
        foreach($params['entry_ids'] as $i => $entry_id)
        {
            $this->EE->db->where('entry_id', $entry_id);
            $this->EE->db->delete('modl_meta_content');
        }
    }

}