<div class="input-field">
    <span @if($mandatory) class="mandatory-input" @endif>{{ $fieldName }}</span>
    <input name="{{ $name }}" type="{{ $inputType }}" value="{{ $inputValue }}" placeholder="{{ $fieldName }}">
</div>