<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @package		MODL Meta - Based on modl_meta
 * @subpackage	ThirdParty
 * @category	Modules
 * @author 		bjorn (original - SEO Lite 1.3.4)
 * @author		Minds On Design Lab (Extended)
 * @link		https://github.com/Minds-On-Design-Lab/modl_meta.ee_addon - Extended from SEO Lite http://ee.bybjorn.com/seo_lite
 */
 
class Modl_meta_mcp 
{
	var $base;			// the base url for this module			
	var $form_base;		// base url for forms
	var $module_name = "modl_meta";	

	function Modl_meta_mcp( $switch = TRUE )
	{
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance(); 
		$this->base	 	 = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module='.$this->module_name;
		$this->form_base = 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module='.$this->module_name;

        // uncomment this if you want navigation buttons at the top
		$this->EE->cp->set_right_nav(array(
				'settings'			=> $this->base,
				'docs'	=> 'https://github.com/Minds-On-Design-Lab/modl_meta.ee_addon',
			));


		//  Onward!
		$this->EE->load->library('table');
		$this->EE->load->helper('form');
		$this->EE->lang->loadfile('modl_meta');
	}

	function index() 
	{
		$vars = array();

        $site_id = $this->EE->config->item('site_id');
        $config = $this->EE->db->get_where('modl_meta_config', array('site_id' => $site_id));

        if($config->num_rows() == 0) // we did not find any config for this site id, so just load any other
        {
            $config = $this->EE->db->get_where('modl_meta_config');
        }

		$vars['template'] = $config->row('template');
        $vars['default_description'] = $config->row('default_description');
        $vars['default_keywords'] = $config->row('default_keywords');
        $vars['default_title_postfix'] = $config->row('default_title_postfix');
		
		// MODL Meta
		$vars['default_og_description'] = $config->row('default_og_description');
		$vars['default_og_image'] = $config->row('default_og_image');
		
		return $this->content_wrapper('index', 'modl_meta_welcome', $vars);
	}
	
	function save_settings()
	{
		$template = $this->EE->input->post('modl_meta_template');
        $default_keywords = $this->EE->input->post('modl_meta_default_keywords');
        $default_description = $this->EE->input->post('modl_meta_default_description');
        $default_title_postfix = $this->EE->input->post('modl_meta_default_title_postfix');
        
        //MODL Meta
		$default_og_description = $this->EE->input->post('modl_meta_default_og_description');
		$default_og_image = $this->EE->input->post('modl_meta_default_og_image');
		
        $site_id = $this->EE->config->item('site_id');
        $config = $this->EE->db->get_where('modl_meta_config', array('site_id' => $site_id));

        $data_arr = array(
                'template' => $template,
                'default_keywords' => $default_keywords,
                'default_description' => $default_description,
                'default_title_postfix' => $default_title_postfix,
                // MODL Meta
                'default_og_description' => $default_og_description,
                'default_og_image' => $default_og_image,
            );

        if($config->num_rows() == 0)
        {
            $data_arr['site_id'] = $site_id;
            $this->EE->db->insert('modl_meta_config', $data_arr);
        }
        else
        {
            $this->EE->db->where('site_id', $site_id);
            $this->EE->db->update('modl_meta_config', $data_arr);
        }

		$this->EE->session->set_flashdata('message_success', lang('settings_saved'));
		$this->EE->functions->redirect($this->base);
	}

	
	function content_wrapper($content_view, $lang_key, $vars = array())
	{
		$vars['content_view'] = $content_view;
		$vars['_base'] = $this->base;
		$vars['_form_base'] = $this->form_base;
		$this->EE->cp->set_variable('cp_page_title', lang($lang_key));
		$this->EE->cp->set_breadcrumb($this->base, lang('modl_meta_module_name'));

		return $this->EE->load->view('_wrapper', $vars, TRUE);
	}
	
}

/* End of file mcp.modl_meta.php */ 
/* Location: ./system/expressionengine/third_party/modl_meta/mcp.modl_meta.php */ 