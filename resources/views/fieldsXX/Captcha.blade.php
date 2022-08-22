<div class="row">
    <div class="medium-4 columns">
        <label for="CaptchaCode" class="middle">{{ trans('recaptcha-response') }}</label>
    </div>
    <div class="medium-8 columns">
        {!! securimage::getCaptchaHtml(
            [
                'input_id'        => 'CaptchaCode'
            ]
        ) !!}
    </div>
</div>
