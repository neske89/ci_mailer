<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-12">
        <div class="py-5 text-center">
            <h2>Email form</h2>
            <p class="lead">Contact us.</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6 offset-3">
        <div class="error">
            <?php echo validation_errors() ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6 offset-3">
        <?php echo form_open('contact') ?>
        <div class="mb-3">
            <label for="email">Email </label>
            <input type="email" name="email" value="<?php echo set_value('email'); ?>" class="form-control" id="email" placeholder="recepient@example.com">
        </div>
        <div class="mb-3">
            <label for="subject">Subject</label>
            <input type="text" name="subject" value="<?php echo set_value('subject'); ?>" class="form-control" id="subject" placeholder="Subject">
        </div>
        <div class="mb-3">
            <label for="subject">Subject</label>
            <textarea required name="message" class="form-control" id="message" placeholder="Message"><?php echo set_value('message'); ?></textarea>
        </div>
        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Send</button>
        <?php echo form_close() ?>
    </div>
</div>
