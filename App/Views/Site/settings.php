<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="fa fa-cogs" aria-hidden="true"></i> Setting</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo PANEL; ?>/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo PANEL; ?>/categories/" class="active"> Setting</a></li>
            <li> <?php echo isset($category->id) ? 'Edit' : 'Add'; ?> Setting</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <form class="form-horizontal" method="post" id="settingsForm" name="settings" enctype="multipart/form-data">
                <?php echo $this->csrfToken(); ?>
                <div class="col-md-7 col-xs-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">General Settings</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Site Title:</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input class="form-control input-sm" id="" placeholder="Title" type="text" name="title" value="<?php echo $this->objval('settings', 'title'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Site Tagline:</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input class="form-control input-sm" id="" placeholder="Some nice slogan" type="text" name="tagline" value="<?php echo $this->objval('settings', 'tagline'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Description:</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <textarea name="description" value=""><?php echo $this->objval('settings', 'description'); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Keywords:</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <textarea placeholder="Keywords" name="keyword"><?php echo $this->objval('settings', 'keyword'); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Author:</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input class="form-control input-sm" id="" placeholder="Editor/Publisher" type="text" name="editor" value="<?php echo $this->objval('settings', 'editor'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Company:</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input class="form-control input-sm" id="" placeholder="XYZ LLC" type="text" name="company" value="<?php echo $this->objval('settings', 'company'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Address:</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <textarea class="input-sm" placeholder="Address" name="address"><?php echo $this->objval('settings', 'address'); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Phone:</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input class="form-control input-sm" id="" placeholder="(xxx) xxx-xxxx" type="text" name="phone" value="<?php echo $this->objval('settings', 'phone'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Fax:</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input class="form-control input-sm" id="" placeholder="(xxx) xxx-xxxx" type="text" name="fax" value="<?php echo $this->objval('settings', 'fax'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Email:</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input class="form-control input-sm" id="" placeholder="(xxx) xxx-xxxx" type="email" name="email" value="<?php echo $this->objval('settings', 'email'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Copyright:</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input class="form-control input-sm" id="" placeholder="Copyright" type="text" name="copyright" value="<?php echo $this->objval('settings', 'copyright'); ?>">
                                </div>
                            </div>
                            <div class="box-footer">
                                <a href="<?php echo PANEL; ?>/" class="btn btn-default btn-sm"><i class="fa fa-close" aria-hidden="true"></i> Close</a>
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>	
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 col-xs-12 pad-left-0">
                    <!--<div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Template Settings</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="template" class="col-sm-3 control-label">Default Template</label>
                                <div class="col-sm-9 col-xs-12 validationHolder">
                                    <select name="default_template" class="form-control">
                                        <?php
/*                                        if (!empty($this->themes)):
                                            foreach ($this->themes as $theme):
                                                echo '<option value="' . $theme . '" ' . ($theme === $this->objval('settings', 'default_template') ? 'selected' : '') . '>' . $theme . '</option>';
                                            endforeach;
                                        endif;
                                        */?>
                                    </select>
                                </div>
                            </div>            
                        </div>
                    </div>-->

                  <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Social Settings</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Shareable Image</label>
                                <div class="col-sm-9 col-xs-12 validationHolder">
                                    <div class="input-group">
                                        <span class="input-group-addon"><?php echo BASE_URL; ?></span>
                                        <input class="form-control input-sm" placeholder="images/og-default.jpg" type="text" name="og_image" value="<?php echo $this->objval('settings', 'og_image'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Facebook Page:</label>
                                <div class="col-sm-9 col-xs-12 validationHolder">
                                    <div class="input-group">
                                        <span class="input-group-addon">https://www.facebook.com/</span>
                                        <input type="text" name="fb_like_page" class="form-control" placeholder="Pagename" value="<?php echo $this->objval('settings', 'fb_like_page'); ?>">
                                    </div>                  
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Twitter Page:</label>
                                <div class="col-sm-9 col-xs-12 validationHolder">
                                    <div class="input-group">
                                        <span class="input-group-addon">https://www.twitter.com/</span>
                                        <input type="text" name="twitter_page" class="form-control" placeholder="twitter-account-name" value="<?php echo $this->objval('settings', 'twitter_page'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Google+ Page:</label>
                                <div class="col-sm-9 col-xs-12 validationHolder">
                                    <input class="form-control input-sm" id="" placeholder="https://www.plus.google.com/" type="url" name="google" 
                                           value="<?php echo $this->objval('settings', 'google'); ?>" 
                                           onfocus="javascript: if (this.value == 'https://www.plus.google.com/https://www.plus.google.com/shokalerkhobor24')
                                                       this.value = '';" onblur="javascript: if (this.value == '')
                                                                   this.value = '<?php echo $this->objval('settings', 'google'); ?>';">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Youtube Page:</label>
                                <div class="col-sm-9 col-xs-12 validationHolder">
                                    <input class="form-control input-sm" id="" placeholder="https://www.youtube.com/" type="url" name="youtube" 
                                           value="<?php echo $this->objval('settings', 'youtube'); ?>" 
                                           onfocus="javascript: if (this.value == 'https://www.youtube.com/https://www.youtube.com/shokalerkhobor24')
                                                       this.value = '';" onblur="javascript: if (this.value == '')
                                                                   this.value = '<?php echo $this->objval('settings', 'youtube'); ?>';">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Linkedin Page:</label>
                                <div class="col-sm-9 col-xs-12 validationHolder">
                                    <input class="form-control input-sm" id="" placeholder="https://www.linkedin.com/" type="text" name="linkedin" 
                                           value="<?php echo $this->objval('settings', 'linkedin'); ?>"
                                           onfocus="javascript: if (this.value == 'https://www.linkedin.com/https://www.linkedin.com/shokalerkhobor24')
                                                       this.value = '';" onblur="javascript: if (this.value == '')
                                                                   this.value = '<?php echo $this->objval('settings', 'linkedin'); ?>';">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Pinterest Page:</label>
                                <div class="col-sm-9 col-xs-12 validationHolder">
                                    <input class="form-control input-sm" id="" placeholder="https://www.pinterest.com/" type="url" name="pinterest"
                                           value="<?php echo $this->objval('settings', 'pinterest'); ?>" 
                                           onfocus="javascript: if (this.value == 'https://www.linkedin.com/https://www.pinterest.com/shokalerkhobor24')
                                                       this.value = '';" onblur="javascript: if (this.value == '')
                                                                   this.value = '<?php echo $this->objval('settings', 'pinterest'); ?>';">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Dafault Video: (Youtube Code)</label>
                                <div class="col-sm-9 col-xs-12 validationHolder">
                                    <input class="form-control input-sm" id="" placeholder="" type="text" name="tv" value="<?php echo $this->objval('settings', 'tv'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Facebook App ID</label>
                                <div class="col-sm-9 col-xs-12 validationHolder">
                                    <input class="form-control input-sm" id="" placeholder="" type="text" name="fb_app_id" value="<?php echo $this->objval('settings', 'fb_app_id'); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>