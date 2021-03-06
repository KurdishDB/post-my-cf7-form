<?php

/**
 * PDisplay OTP tab settings in CF& editor page.
 *
 * @link       https://profiles.wordpress.org/aurovrata/
 * @since      5.0.0
 *
 * @package    Cf7_2_Post
 * @subpackage Cf7_2_Post/admin/partials
 */

 require_once plugin_dir_path( dirname( __DIR__ ) ) . 'includes/class-cf7-2-post-factory.php' ;

 //action
 $is_new_mapping = true;
 switch($factory_mapping->get('map')){
   case 'draft':
     $is_new_mapping = true;
     break;
   case 'publish':
     $is_new_mapping = false;
     break;
 }
 $post_type = $factory_mapping->get('type');
 $source = $factory_mapping->get('type_source');
 $post_name = '';
 $class_factory = '';
 $system_factory=' display-none';
 switch($source){
   case 'factory':
     $post_name = $factory_mapping->get('plural_name');
     break;
   case 'system':
     $post_obj = get_post_type_object( $post_type );
     $post_name = $post_obj->labels->name;
     $class_factory = ' display-none';
     $system_factory='';
     break;
 }
 $post_fields = '
   <li>
     <div class="cf7-2-post-field">
       <label class="cf7-2-post-map-labels" for="cf7-2-%2$s"><strong>%1$s</strong></label>
       <select id="cf7-2-%2$s" value="%3$s" name="cf7_2_post_map-%2$s" class="field-options post-options nice-select">
         <option class="default-option" value="">'. __('Select a form field', 'post-my-contact-form-7' ). '</option>
         <option class="filter-option" value="cf7_2_post_filter-'.$post_type.'-%2$s">'.__('Hook with a filter', 'post-my-contact-form-7' ). '</option>
       </select>
     </div><span class="cf7-post-msg"></span>
   </li>';
 ?>
<h3><?php esc_html_e('Save submissions as ','post-my-contact-form-7' ); ?>&quot;<span id="custom-post-title"><?= $post_name ;?>&nbsp;(<?= $post_type?>)</span>&quot;</h3>
<?php if(!is_plugin_active('cf7-grid-layout/cf7-grid-layout.php')):
   $form = get_post($cf7_post_id);
?>
   <input type="hidden" id="post_name" value="<?=$form->post_name?>"/>
<?php endif;?>

<input type="hidden" name="action" value="save_post_mapping"/>
 <?php wp_nonce_field('cf7_2_post_mapping', 'cf7_2_post_nonce', false, true);?>

<h2><?=__('Save form to post','post-my-contact-form-7' )?></h2>
<input name="mapped_post_type" <?php $factory_mapping->is_published();?> id="mapped-post-type" value="<?php echo $factory_mapping->get('type');?>" type="hidden">

<div class="factory-post">
   <div>
      <label class="post_type_labels" for="post_type"><?=__('Post Type:','post-my-contact-form-7')?></label>
      <span id="post-type-display">
        <select name="mapped_post_type_source" id="post_type_source" class="nice--select" <?php $factory_mapping->is_published();?>>
          <option value="factory" <?= ('factory'==$source) ? ' selected="true"' : ''; ?>><?= __('New Post','post-my-contact-form-7')?></option>
          <option value="system"<?php echo ('system'==$source) ? ' selected="true"' : ''; ?>><?=__('Existing Post','post-my-contact-form-7')?></option>
        </select>
      </span>
   </div>
   <div id="post-type-exists"<?= ('system'==$source)? '':' class="display-none"';?>>
     <label class="post_type_labels" for="system_post_type"><?=__('Select a Post','post-my-contact-form-7')?></label>
     <select id="system-post-type" class="nice--select right" name="system_post_type" <?php $factory_mapping->is_published();?>>
       <option value=""><?=__('Select a Post','post-my-contact-form-7')?></option>
       <?php echo $factory_mapping->get_system_posts_options();?>
     </select>
   </div>
   <div id="post-type-select" <?php echo ('system'==$source)?' class="display-none"':'';?>> <!--class="hide-if-js"-->
     <label for="custom_post_type" class="post_type_labels"><?=__('Post type', 'post-my-contact-form-7')?></label>
     <input name="custom_post_type" <?php $factory_mapping->is_published();?> id="custom_post_type" value="<?php echo $factory_mapping->get('type');?>" type="text">

     <label for="mapped_post_singular_name" class="post_type_labels"><?=__('Singular name', 'post-my-contact-form-7');?></label>
     <input name="mapped_post_singular_name"  <?php $factory_mapping->is_published();?> id="post_singular_name" value="<?php echo $factory_mapping->get('singular_name');?>" type="text">
     <label for="mapped_post_plural_name" class="post_type_labels"><?=__('Plural name','post-my-contact-form-7')?></label>
     <input name="mapped_post_plural_name" <?php $factory_mapping->is_published();?>  id="post_plural_name" value="<?php echo $factory_mapping->get('plural_name');?>" type="text">
     <p class="post-type-display">
       <?=__('Attributes','post-my-contact-form-7')?>
     </p>
     <input type="checkbox" <?php $factory_mapping->is('hierarchical','checked="checked"');?> name="mapped_post_hierarchical"/>
     <label class="post_type_cb_labels">hierarchical</label><br />
     <input type="checkbox" <?php $factory_mapping->is('public','checked="checked"');?> name="mapped_post_public"/>
     <label class="post_type_cb_labels">public</label><br />
     <input type="checkbox" <?php $factory_mapping->is('show_ui','checked="checked"');?> name="mapped_post_show_ui"/>
     <label class="post_type_cb_labels">show_ui</label><br />
     <input id="menu-position-checkbox" type="checkbox" <?php $factory_mapping->is('show_in_menu','checked="checked"');?> name="mapped_post_show_in_menu"/>
     <label class="post_type_cb_labels">show_in_menu</label><br />
     <div id="menu-position"><label>menu_position</label>
       <input style="width:45px;" type="number" value="<?= $factory_mapping->get('menu_position');?>" size="3" name="mapped_post_menu_position"/>
     </div>
     <input type="checkbox" <?php $factory_mapping->is('show_in_admin_bar','checked="checked"');?> name="mapped_post_show_in_admin_bar"/>
     <label class="post_type_cb_labels">show_in_admin_bar</label><br />
     <input type="checkbox" <?php $factory_mapping->is('show_in_nav_menus','checked="checked"');?> name="mapped_post_show_in_nav_menus"/>
     <label class="post_type_cb_labels">show_in_nav_menus</label><br />
     <input type="checkbox" <?php $factory_mapping->is('can_export','checked="checked"');?> name="mapped_post_can_export"/>
     <label class="post_type_cb_labels">can_export</label><br />
     <input type="checkbox" <?php $factory_mapping->is('has_archive','checked="checked"');?> name="mapped_post_has_archive"/>
     <label class="post_type_cb_labels">has_archive</label><br />
     <input type="checkbox" <?php $factory_mapping->is('exclude_from_search','checked="checked"');?> name="mapped_post_exclude_from_search"/>
     <label class="post_type_cb_labels">exclude_from_search</label><br />
     <input type="checkbox" <?php $factory_mapping->is('publicly_queryable','checked="checked"');?> name="mapped_post_publicly_queryable"/>
     <label class="post_type_cb_labels">publicly_queryable</label><br />
     <div class="clear"></div>
   </div><!-- end post-type-select -->
</div>
<h2><?=__('Default post fields', 'post-my-contact-form-7')?></h2>
<ul class="default-post-fields">
   <?php
   echo sprintf( $post_fields, __('Post title', 'post-my-contact-form-7' ),'title',$factory_mapping->get_mapped_form_field('title'));
   echo sprintf($post_fields, __('Post Content', 'post-my-contact-form-7' ),'editor',$factory_mapping->get_mapped_form_field('editor'));
   echo sprintf($post_fields, __('Post Excerpt', 'post-my-contact-form-7' ),'excerpt',$factory_mapping->get_mapped_form_field('excerpt'));
   echo sprintf($post_fields, __('Featured image', 'post-my-contact-form-7' ),'thumbnail',$factory_mapping->get_mapped_form_field('thumbnail'));
   echo sprintf($post_fields, __('Post slug', 'post-my-contact-form-7' ),'slug',$factory_mapping->get_mapped_form_field('slug'));
   echo sprintf($post_fields, __('Post author', 'post-my-contact-form-7' ),'author',$factory_mapping->get_mapped_form_field('author'));
   ?>
</ul>
<h2><?=__('Custom Meta Fields','post-my-contact-form-7' )?></h2>
<ul class="default-post-meta-fields">
<?php include_once 'cf7-2-post-field-metabox.php'; ?>
</ul>
<p><?=__('Custom fields can be used to add extra metadata to a post that you can <a href="https://codex.wordpress.org/Using_Custom_Fields">use in your theme</a>','post-my-contact-form-7')?>.</p>
