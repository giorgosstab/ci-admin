<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container" style="margin-top:60px;">
    <div class="row">
        <div class="col-lg-12">
            <a href="<?php echo site_url('admin/categories/create');?>" class="btn btn-primary">Add category</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <?php
            echo '<table class="table table-hover table-bordered table-condensed">';
            echo '<tr><td rowspan="2">ID</td><td rowspan="2">Category name</td></td><td colspan="'.sizeof($languages).'">Languages</td><td rowspan="2">Operations</td></tr>';
            echo '<tr>';
            foreach($languages as $language)
            {
                echo '<td>'.$language->slug.'</td>';
            }
            echo '</tr>';
            if(!empty($categories))
            {

                foreach($categories as $id => $categ)
                {
                    echo '<tr>';
                    echo '<td>'.$id.'</td><td>'.$categ['name'].'</td>';
                    foreach($languages as $language)
                    {
                        echo '<td>';
                        if(isset($categ['languages'][$language->id]))
                        {
                            echo anchor('admin/categories/edit/'.$categ['languages'][$language->id]['translation_id'], '<span class="glyphicon glyphicon-pencil"></span>');
                            echo ' ';
                            echo anchor('admin/categories/delete/'.$categ['languages'][$language->id]['translation_id'], '<span class="glyphicon glyphicon-remove"></span>');
                        }
                        else
                        {
                            echo anchor('admin/categories/create/'.$id.'/'.$language->id, '<span class="glyphicon glyphicon-plus"></span>');
                        }
                        echo '</td>';
                    }

                    echo '<td>'.anchor('admin/categories/edit-pack/'.$id,'<span class="glyphicon glyphicon-pencil"></span>').' '.anchor('admin/categories/delete-pack/'.$id,'<span class="glyphicon glyphicon-remove"></span>').'</td>';
                    echo '</tr>';
                }

            }
            echo '</table>';
            ?>
        </div>
    </div>
</div>