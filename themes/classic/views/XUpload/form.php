<?php
/**
 * Created by PhpStorm.
 * User: mariabiryukova
 * Date: 19.05.18
 * Time: 22:36
 */

if ($this->showForm) echo CHtml::beginForm($this -> url, 'post', $this -> htmlOptions);?>
    <div class="row fileupload-buttonbar">

        <span class="btn btn-success fileinput-button">
            <label for="XUploadForm_file"><?php echo $this->t('1#Add files|0#Choose file', $this->multiple); ?></label>
            <button class="btn">
                <i>Выбрать</i>
            </button>
            <?php
            if ($this -> hasModel()) :
                echo CHtml::activeFileField($this -> model, $this -> attribute, $htmlOptions) . "\n";
            else :
                echo CHtml::fileField($name, $this -> value, $htmlOptions) . "\n";
            endif;
            ?>
		</span>
        <div class="span5">
            <!-- The global progress bar -->
            <div class="progress progress-success progress-striped active fade">
                <div class="bar" style="width:0%;"></div>
            </div>
        </div>
    </div>
    <!-- The loading indicator is shown during image processing -->
    <div class="fileupload-loading"></div>
    <!-- The table listing the files available for upload/download -->
    <table class="table table-striped">
        <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
    </table>
<?php if ($this->showForm) echo CHtml::endForm();?>

