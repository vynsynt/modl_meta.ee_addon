<style type="text/css">
    .fullwidth {
        width:100%;
    }

    #instructions {
        display:none;
    }
</style>

<script type="text/javascript">

    $(document).ready(
            function() {

                $('#view_instructions').click(function(){
                    if($('#instructions').is(':visible')) {
                        $('#instructions').hide('fast');
                        $('#view_instructions').html('Show instructions');
                    }
                    else
                    {
                        $('#instructions').show('fast');
                        $('#view_instructions').html('Hide instructions');
                    }
                });
                
            });

</script>

<h3><a href="#" id="view_instructions">View instructions</a></h3>

    <div id="instructions">
        <p>Put one of these tags in your template:</p>

        <p>By <strong>segment</strong>: <input type='text' class="fullwidth" value='{exp:modl_meta url_title="{segment_3}"}' readonly/> </p>
        <p>By <strong>entry_id</strong>: <input type='text' class="fullwidth" value='{exp:modl_meta entry_id="{entry_id}"}' readonly/></p>
        <p><strong>Intelligent mode</strong> aka Use-Last-Segment-Mode: <input type='text' class="fullwidth" value='{exp:modl_meta use_last_segment="yes"}' readonly/></p>
        <p><strong>Static mode</strong> aka I-Will-Provide-Values-In-Template: (this will output "About Us" for the title tag but still use the default keywords/description for the site) <input type='text' class="fullwidth" value='{exp:modl_meta default_title="About us"}' readonly/></p></p>
        <p><strong>Static mode</strong> with everything overridden: <input type='text' class="fullwidth" value='{exp:modl_meta default_title="About us" default_keywords="new, keywords" default_description="This description is unique for this page"}' readonly/></p></p>

        <p>&nbsp;</p>
        <p><em>Either of these tags will output the template below with the title/keywords/description specific for the content. The template below is parsed as a normal EE template, so you can use any EE global variavbles and conditionals etc.</em> <a href="http://ee.bybjorn.com/modl_meta">More instructions available here.</a></p>

        <p>&nbsp;</p>
    </div>

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


        $this->table->add_row(array(
	            lang('default_title_postfix', 'modl_meta_default_title_postfix'),
	            form_error('modl_meta_default_title_postfix').
	            form_input('modl_meta_default_title_postfix', set_value('modl_meta_default_title_postfix', $default_title_postfix), 'id="modl_meta_default_title_postfix"')
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