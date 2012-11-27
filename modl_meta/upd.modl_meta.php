<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @package		MODL Meta - Extentended from SEO_lite
 * @subpackage	ThirdParty
 * @category	Modules
 * @author 		bjorn (original - SEO Lite 1.3.4)
 * @author		Minds On Design Lab (Extended)
 * @link		https://github.com/Minds-On-Design-Lab/modl_meta.ee_addon - Extended from SEO Lite http://ee.bybjorn.com/seo_lite
 */
 
class Modl_meta_upd {
		
	var $version        = '1.0.2';
	var $module_name = "Modl_meta";

    /**
     * @var Devkit_code_completion
     */
    public $EE;

    function modl_meta_upd( $switch = TRUE ) 
    { 
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();
    } 

    /**
     * Installer for the modl_meta module
     */
    function install() 
	{				
		$site_id = $this->EE->config->item('site_id');
		if($site_id == 0)	// if MODL Meta is installed with a theme site_id will be 0, so set it to 1
		{
			$site_id = 1;
		}
		
		$data = array(
			'module_name' 	 => $this->module_name,
			'module_version' => $this->version,
			'has_cp_backend' => 'y',
            'has_publish_fields' => 'y'            
		);

		$this->EE->db->insert('modules', $data);		

        $this->EE->load->dbforge();
		
		// Check for SEO Lite Tables and run conversion
		
		if ($this->EE->db->table_exists('exp_seolite_content') AND $this->EE->db->table_exists('exp_seolite_config'))
		{
		   
		   	// Rename tables
		   	$this->EE->dbforge->rename_table('exp_seolite_content', 'exp_modl_meta_content');
		   	$this->EE->dbforge->rename_table('exp_seolite_config', 'exp_modl_meta_config');
		   
		   	// Rename existing columns tables
		   	$fields = array(
				'seolite_content_id' => array(
					'name' => 'modl_meta_content_id',
					'type' => 'INT',
					'contstraint' => 10,
					'unsigned' => TRUE,
					'auto_increment' => TRUE
				),
			);
			$this->EE->dbforge->modify_column('modl_meta_content', $fields);
			
		   	$fields = array(
				'seolite_config_id' => array(
					'name' => 'modl_meta_config_id',
					'type' => 'INT',
					'constraint' => 10,
					'unsigned' => TRUE,
					'auto_increment' => TRUE
				),
			);
			$this->EE->dbforge->modify_column('modl_meta_config', $fields);
		   	
		   	// Add new fields to content table
		   	$modl_meta_content_fields = array(
				// MODL Meta
				'og_title' => array(
					'type' => 'varchar',
					'constraint' => '1024',
					), 
				'og_description' => array(
					'type' => 'text',
					),
				'og_type' => array(
					'type' => 'varchar',
					'constraint' => '255',
					),
				'og_image' => array(
					'type' => 'text',
					),
			);
			
			$this->EE->dbforge->add_column('modl_meta_content', $modl_meta_content_fields);
		   	
		   	// Add new fields to config table

		   	$modl_meta_config_fields = array(
				// MODL Meta
				'default_og_description' => array(
					'type' => 'varchar',
					'constraint' => '255',
					'null' => FALSE
					),
				'default_og_image' => array(
					'type' => 'varchar',
					'constraint' => '1024',
					'null' => FALSE
					),
				'default_fb_admin' => array(
					'type' => 'varchar',
					'constraint' => '1024',
					'null' => FALSE
					),
				'og_fb_admin' => array(
					'type' => 'varchar',
					'constraint' => '1024',
					'null' => FALSE
					),		
			);
			$this->EE->dbforge->add_column('modl_meta_config', $modl_meta_config_fields);
		   	
		} else {
		
			$modl_meta_content_fields = array(
				'modl_meta_content_id' => array(
					'type' => 'int',
					'constraint' => '10',
					'unsigned' => TRUE,
					'auto_increment' => TRUE,
					),
				'site_id' => array(
					'type' => 'int',
					'constraint' => '10',
					'null' => FALSE,
					),
				'entry_id' => array(
					'type' => 'int',
					'constraint' => '10',
					'null' => FALSE,
					),				
				'title' => array(
					'type' => 'varchar',
					'constraint' => '1024',
					),            
				'keywords' => array(
					'type' => 'varchar',
					'constraint' => '1024',
					'null' => FALSE,
					),
				'description' => array(
					'type' => 'text',
					),
				// MODL Meta
				'og_title' => array(
					'type' => 'varchar',
					'constraint' => '1024',
					), 
				'og_description' => array(
					'type' => 'text',
					),
				'og_type' => array(
					'type' => 'varchar',
					'constraint' => '255',
					),
				'og_image' => array(
					'type' => 'text',
					),
			);
			
			$this->EE->dbforge->add_field($modl_meta_content_fields);
        	$this->EE->dbforge->add_key('modl_meta_content_id', TRUE);
        	$this->EE->dbforge->create_table('modl_meta_content');
        	
        	$modl_meta_config_fields = array(
				'modl_meta_config_id' => array(
					'type' => 'int',
					'constraint' => '10',
					'unsigned' => TRUE,
					'auto_increment' => TRUE,
					),
				'site_id' => array(
					'type' => 'int',
					'constraint' => '10',
					'unsigned' => TRUE,
					),
				'template' => array(
					'type' => 'text',),
					'default_keywords' => array(
					'type' => 'varchar',
					'constraint' => '255',
					'null' => FALSE,
					),
				'default_description' => array(
					'type' => 'varchar',
					'constraint' => '255',
					'null' => FALSE
					),
				'default_title_postfix' => array(
					'type' => 'varchar',
					'constraint' => '60',
					'null' => FALSE
					),
				// MODL Meta
				'default_og_description' => array(
					'type' => 'varchar',
					'constraint' => '255',
					'null' => FALSE
					),
				'default_og_image' => array(
					'type' => 'varchar',
					'constraint' => '1024',
					'null' => FALSE
					),
				'default_fb_admin' => array(
					'type' => 'varchar',
					'constraint' => '1024',
					'null' => FALSE
					),
				'og_fb_admin' => array(
					'type' => 'varchar',
					'constraint' => '1024',
					'null' => FALSE
					),		
			);
			
			$this->EE->dbforge->add_field($modl_meta_config_fields);
       		$this->EE->dbforge->add_key('modl_meta_config_id', TRUE);
	        $this->EE->dbforge->create_table('modl_meta_config');
	        
	        // insert default config
	        $this->EE->db->insert('modl_meta_config', array(
				'template' => "<title>{title}{site_name}</title>\n<meta name='keywords' content='{meta_keywords}' />\n<meta name='description' content='{meta_description}' />\n<link rel='canonical' href='{canonical_url}' />\n<!--Open Graph Tags-->\n<meta property=\"og:site_name\" content=\"{site_name}\"/>\n<meta property=\"og:title\" content=\"{meta_og_title}\"/>\n<meta property=\"og:url\" content=\"{canonical_url}\"/>\n{if meta_og_description}<meta property=\"og:description\" content=\"{meta_og_description}\"/>\n{/if}{if meta_og_image}<meta property=\"og:image\" content=\"{meta_og_image}\"/>\n{/if}{if meta_og_type}<meta property=\"og:type\" content=\"{meta_og_type}\"/>\n{/if}<meta property=\"fb:admins\" content=\"{meta_og_fb_admin}\"/>\n<!-- generated by modl_meta -->",
				'site_id' => $site_id,
				'default_keywords' => 'your, default, keywords, here',
				'default_description' => 'Your default description here',
				'default_title_postfix' => ' |&nbsp;',
				// MODL Meta
				'default_og_description' => 'Your default Open Graph description here. Leave blank if you would prefer not to provide one.',
				'default_og_image' => '',
				'og_fb_admin' => ''
	        ));	
		}
		
        // Setup Tabs

        $this->EE->load->library('layout');
        $this->EE->layout->add_layout_tabs($this->tabs(), 'modl_meta');

		return TRUE;
	}

    function tabs()
    {
        $tabs['modl_meta'] = array(
            'modl_meta_title'=> array(
                'visible'	=> 'true',
                'collapse'	=> 'false',
                'htmlbuttons'	=> 'false',
                'width'		=> '100%'
                ),
            'modl_meta_keywords'=> array(
                'visible'	=> 'true',
                'collapse'	=> 'false',
                'htmlbuttons'	=> 'false',
                'width'		=> '100%'
                ),
            'modl_meta_description' => array(
                'visible'	=> 'true',
                'collapse'	=> 'false',
                'htmlbuttons'	=> 'false',
                'width'		=> '100%',
                ),
            // MODL Meta
            'modl_meta_og_title'=> array(
                'visible'	=> 'true',
                'collapse'	=> 'false',
                'htmlbuttons'	=> 'false',
                'width'		=> '100%'
                ),
            'modl_meta_og_description' => array(
                'visible'	=> 'true',
                'collapse'	=> 'false',
                'htmlbuttons'	=> 'false',
                'width'		=> '100%',
                ),
            'modl_meta_og_type' => array(
                'visible'	=> 'true',
                'collapse'	=> 'false',
                'htmlbuttons'	=> 'false',
                'width'		=> '100%',
                ),
            'modl_meta_og_image' => array(
                'visible'	=> 'true',
                'collapse'	=> 'false',
                'htmlbuttons'	=> 'false',
                'width'		=> '100%',
                ),            
            );

        return $tabs;
    }

	
	/**
	 * Uninstall the modl_meta module
	 */
	function uninstall() 
	{ 				
        $this->EE->load->dbforge();
        
		$this->EE->db->select('module_id');
		$query = $this->EE->db->get_where('modules', array('module_name' => $this->module_name));
		
		$this->EE->db->where('module_id', $query->row('module_id'));
		$this->EE->db->delete('module_member_groups');
		
		$this->EE->db->where('module_name', $this->module_name);
		$this->EE->db->delete('modules');
		
		$this->EE->db->where('class', $this->module_name);
		$this->EE->db->delete('actions');
		
		$this->EE->db->where('class', $this->module_name.'_mcp');
		$this->EE->db->delete('actions');

        $this->EE->dbforge->drop_table('modl_meta_content');
        $this->EE->dbforge->drop_table('modl_meta_config');

        $this->EE->load->library('layout');
        $this->EE->layout->delete_layout_tabs($this->tabs(), 'modl_meta');

		return TRUE;
	}
	
	/**
	 * Update the modl_meta module
	 * 
	 * @param $current current version number
	 * @return boolean indicating whether or not the module was updated 
	 */
    function update($current = '')
    {
        if ($current == $this->version)
        {
            return FALSE;
        }
		
        return TRUE;
    }
    
}

/* End of file upd.modl_meta.php */ 
/* Location: ./system/expressionengine/third_party/modl_meta/upd.modl_meta.php */ 