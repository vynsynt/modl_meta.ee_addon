
<h3>MODL Meta Settings</h3>
<p>The following are key configuration settings and site wide defaults.</p>
<?php
	$this->table->set_template($cp_table_template);
	$this->table->set_heading(array(
			array('data' => lang('setting'), 'width' => '50%'),
			lang('current_value')
		)
	);
?>

<?=form_open($_form_base.'&method=save_settings')?>

	<?php 

        $this->table->add_row(array(
                lang('template', 'modl_meta_template'),
                form_error('modl_meta_template').
                form_textarea('modl_meta_template', set_value('modl_meta_template', $template), 'id="modl_meta_template"')
            )
        );

        $this->table->add_row(array(
                lang('default_title_postfix', 'modl_meta_default_title_postfix'),
                form_error('modl_meta_default_title_postfix').
                form_input('modl_meta_default_title_postfix', set_value('modl_meta_default_title_postfix', $default_title_postfix), 'id="modl_meta_default_title_postfix"')
            )
        );

        echo $this->table->generate();
    ?>
    <h3>Basic Meta Defaults</h3>
    <p>The following are default SEO meta settings. Page title is managed per entry or via a template tag and does not have a site default.</p>
    <?php    

        $this->table->set_heading(array(
            array('data' => lang('setting'), 'width' => '50%'),
            lang('current_value')
            )
        );

		$this->table->add_row(array(
				lang('default_keywords', 'modl_meta_default_keywords'),
				form_error('modl_meta_default_keywords').
				form_input('modl_meta_default_keywords', set_value('modl_meta_default_keywords', $default_keywords), 'id="modl_meta_default_keywords"')
			)
		);
		
        $this->table->add_row(array(
                lang('default_description', 'modl_meta_default_description'),
                form_error('modl_meta_default_description').
                form_textarea('modl_meta_default_description', set_value('modl_meta_default_description', $default_description), 'id="modl_meta_default_description"')
            )
        );

        echo $this->table->generate();
    ?>
    <h3>Open Graph Meta Defaults</h3>
    <p>The following are default Open Graph settings. Not all basic Open Graph tags make sense to have site defaults as "og:type" is a per entry setting, and title will be either drawn dynamically from entry or added to template tag.</p>
    <?php
        $this->table->set_heading(array(
            array('data' => lang('setting'), 'width' => '50%'),
            lang('current_value')
            )
        );

		$this->table->add_row(array(
		        lang('default_og_description', 'modl_meta_default_og_description'),
		        form_error('modl_meta_default_og_description').
		        form_textarea('modl_meta_default_og_description', set_value('modl_meta_default_og_description', $default_og_description), 'id="modl_meta_default_og_description"')
            )
        );
        
        $this->table->add_row(array(
	            lang('default_og_image', 'modl_meta_default_og_image'),
	            form_error('modl_meta_default_og_image').
	            form_input('modl_meta_default_og_image', set_value('modl_meta_default_og_image', $default_og_image), 'id="modl_meta_default_og_image"')
            )
        );
        echo $this->table->generate();
	?>
	<p>
		<?=form_submit(array('name' => 'submit', 'value' => lang('update'), 'class' => 'submit'))?>
	</p>

<?=form_close()?>

<?php
/* End of file index.php */
/* Location: ./system/expressionengine/third_party/modl_meta/views/index.php */