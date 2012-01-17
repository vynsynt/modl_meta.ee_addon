<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * One calorie SEO module, no sugar added!
 *
 * @package		Seo_lite
 * @subpackage	ThirdParty
 * @category	Modules
 * @author		bjorn
 * @link		http://ee.bybjorn.com/seo_lite
 */

class Seo_lite_tab {

    public function __construct()
    {
        $this->EE =& get_instance();
        $this->EE->lang->loadfile('seo_lite');

        if($this->EE->config->item('seo_lite_tab_title')) {
            $this->EE->lang->language['seo_lite'] = $this->EE->config->item('seo_lite_tab_title');
        }
    }

    public function publish_tabs($channel_id, $entry_id = '')
    {
        $settings = array();

        $title = $keywords = $description = $og_description = $og_image = $og_type = '';
        if($entry_id)
        {
            $q = $this->EE->db->get_where('seolite_content', array('entry_id' => $entry_id));
            if($q->num_rows())
            {
                $title = $q->row('title');
                $keywords = $q->row('keywords');
                $description = $q->row('description');
                //Open Graph
                $og_type = $q->row('og_type');
                $og_description = $q->row('og_description');
                $og_image = $q->row('og_image');
            }
        }

        $settings[] = array(
           'field_id' => 'seo_lite_title',
           'field_label' => lang('seotitle'),
           'field_required' => 'n',
           'field_data' => $title,
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
           'field_id' => 'seo_lite_keywords',
           'field_label' => lang('seokeywords'),
           'field_required' => 'n',
           'field_data' => $keywords,
           'field_list_items' => '',
           'field_fmt' => '',
           'field_instructions' => lang('keywords_instructions'),
           'field_show_fmt' => 'n',
           'field_fmt_options' => array(),
           'field_pre_populate' => 'n',
           'field_text_direction' => 'ltr',
            'field_type' => 'textarea',
            'field_ta_rows'		   => 5,
       );

        $settings[] = array(
           'field_id' => 'seo_lite_description',
           'field_label' => lang('seodescription'),
           'field_required' => 'n',
           'field_data' => $description,
           'field_list_items' => '',
           'field_fmt' => '',
           'field_instructions' => lang('description_instructions'),
           'field_show_fmt' => 'n',
           'field_fmt_options' => array(),
           'field_pre_populate' => 'n',
           'field_text_direction' => 'ltr',
           'field_type' => 'textarea',
           'field_ta_rows'		   => 5,

       );
       
       // Open Graph
       
        $settings[] = array(
           'field_id' => 'seo_lite_og_type',
           'field_label' => lang('og_type'),
           'field_required' => 'n',
           'field_data' => $og_type,
           'field_list_items' => array(
           		'' => '-- Select Type --',
           		'article' => 'Article',
           		'blog' => 'Blog',
           		'website' => 'Website',
           		'activity' => 'Activity',
           		'sport' => 'Sport',
           		'bar' => 'Bar',
				'company' => 'Company',
				'cafe' => 'Cafe',
				'hotel' => 'Hotel',
				'restaurant' => 'Restaurant'
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
           'field_id' => 'seo_lite_og_description',
           'field_label' => lang('og_description'),
           'field_required' => 'n',
           'field_data' => $og_description,
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
           'field_id' => 'seo_lite_og_image',
           'field_label' => lang('og_image'),
           'field_required' => 'n',
           'field_data' => $og_image,
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
        $seo_lite_data = $params['mod_data'];
        $site_id = $params['meta']['site_id'];
        $entry_id = $params['entry_id'];

        $content = array(
            'site_id' => $site_id,
            'entry_id' => $entry_id,
            'title' => $seo_lite_data['seo_lite_title'],
            'keywords' => $seo_lite_data['seo_lite_keywords'],
            'description' => $seo_lite_data['seo_lite_description'],
            // Open Graph
            'og_type' => $seo_lite_data['seo_lite_og_type'],
            'og_description' => $seo_lite_data['seo_lite_og_description'],
            'og_title' => $seo_lite_data['seo_lite_og_title'],
        );

        $q = $this->EE->db->get_where('seolite_content', array('site_id' => $site_id, 'entry_id' => $entry_id));
        if($q->num_rows())
        {
            $this->EE->db->where('entry_id', $entry_id);
            $this->EE->db->where('site_id', $site_id);
            $this->EE->db->update('seolite_content', $content);
        }
        else
        {
            $this->EE->db->insert('seolite_content', $content);
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
            $this->EE->db->delete('seolite_content');
        }
    }

}