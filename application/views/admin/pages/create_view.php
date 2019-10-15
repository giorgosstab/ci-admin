2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
35
36
37
38
39
40
41
42
43
44
45
46
47
48
49
50
51
52
53
54
55
56
57
58
59
60
61
62
63
64
65
66
67
68
69
70
71
72
73
74
75
76
77
78
79
80
81
82
83
84
85
86
87
88
89
	
<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container" style="margin-top:60px;">
    <div class="row">
        <div class="col-lg-12">
            <h1>Add Page in <?php echo strtolower($content_language);?></h1>
            <?php echo form_open('',array('class'=>'form-horizontal'));?>
            <div class="form-group">
                <?php
                echo form_label('Parent page','parent_id');
                echo form_dropdown('parent_id',$parent_pages,set_value('parent_id',(isset($page->parent_id) ? $page->parent_id : '0')),'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Title','title');
                echo form_error('title');
                echo form_input('title',set_value('title'),'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Menu title','menu_title');
                echo form_error('menu_title');
                echo form_input('menu_title',set_value('menu_title'),'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Slug','slug');
                echo form_error('slug');
                echo form_input('slug',set_value('slug'),'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Order','order');
                echo form_error('order');
                echo form_input('order',set_value('order', (isset($page->order) ? $page->order : '0')),'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Teaser','teaser');
                echo form_error('teaser');
                echo form_textarea('teaser',set_value('teaser'),'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Content','content');
                echo form_error('content');
                echo form_textarea('content',set_value('content','',false),'class="form-control"');
                ?>
            </div>
 
            <div class="form-group">
                <?php
                echo form_label('Page title','page_title');
                echo form_error('page_title');
                echo form_input('page_title',set_value('page_title'),'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Page description','page_description');
                echo form_error('page_description');
                echo form_input('page_description',set_value('page_description'),'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Keywords','page_keywords');
                echo form_error('page_keywords');
                echo form_input('page_keywords',set_value('page_keywords'),'class="form-control"');
                ?>
            </div>
            <?php echo form_error('page_id');?>
            <?php echo form_hidden('page_id',set_value('page_id',$page_id));?>
            <?php echo form_error('language_slug');?>
            <?php echo form_hidden('language_slug',set_value('language_slug',$language_slug));?>
            <?php
            $submit_button = 'Add page';
            if($page_id!=0) $submit_button = 'Add translation';
            echo form_submit('submit', $submit_button, 'class="btn btn-primary btn-lg btn-block"');?>
            <?php echo anchor('/admin/pages', 'Cancel','class="btn btn-default btn-lg btn-block"');?>
            <?php echo form_close();?>
        </div>
    </div>
</div>