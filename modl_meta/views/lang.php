
<h3>MODL Meta Settings</h3>
<p>Update and manage language settings for meta fields</p>
<?php
	$this->table->set_template($cp_table_template);
	$this->table->set_heading(array(
			lang('language'),
            lang('language_cc')
		)
	);
?>

<?=form_open($_form_base.'&method=save_langs')?>
    <?php foreach( $languages as $cc => $label ) : ?>

        <?php

            $this->table->add_row(array(
                form_input('modl_meta_languages[]', $label),
                form_input('modl_meta_languages_codes[]', $cc),
            ));
        ?>
    <?php endforeach ?>

	<?php

        $this->table->add_row(array(
            form_input('modl_meta_languages[]'),
            form_input('modl_meta_languages_codes[]'),
        ));

        echo $this->table->generate();
    ?>
	<p>
		<?=form_submit(array('name' => 'submit', 'value' => lang('update'), 'class' => 'submit'))?>
	</p>

<?=form_close()?>

<?php
/* End of file lang.php */
/* Location: ./system/expressionengine/third_party/modl_meta/views/lang.php */