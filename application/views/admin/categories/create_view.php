<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container" style="margin-top:60px;">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <h1>Add category</h1>
            <?php echo form_open('',array('class'=>'form-horizontal'));?>
            <div class="form-group">
                <?php
                echo form_label('Language','language_id');
                echo form_dropdown('language_id',$languages,set_value('language_id',$default_language),'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Parent category','parent_id');
                echo form_dropdown('parent_id',$categories,set_value('parent_id',$parent_id),'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Category name','name');
                echo form_error('name');
                echo form_input('name',set_value('name'),'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Category description','description');
                echo form_error('description');
                echo form_input('description',set_value('description'),'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Category slug','slug');
                echo form_error('slug');
                echo form_input('slug',set_value('slug'),'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Order','order');
                echo form_error('order');
                echo form_input('order',set_value('order',$order),'class="form-control"');
                ?>
            </div>
            <?php echo form_hidden('pack_id',set_value('pack_id',$pack_id));?>
            <?php echo form_submit('submit', 'Add category', 'class="btn btn-primary btn-lg btn-block"');?>
            <?php echo anchor('/admin/categories', 'Cancel','class="btn btn-default btn-lg btn-block"');?>
            <?php echo form_close();?>
        </div>
    </div>
</div>