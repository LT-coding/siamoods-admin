<style>
    .canvas-container, canvas {
        max-width: 100%;
        width: 100%;
    }
</style>
@php
    $align = ['left'=>'Left','center'=>'Center','right'=>'Right'];
@endphp
<div class="controls p-1 mb-2 border">
    <h5>Text Tools</h5>
    <div class="row">
        <div class="col-sm-2">
            <x-adminlte-input name="size" placeholder="Font Size" type="number" id="font-size-input" min="1" max="72" value="20" onchange="changeTextFontSize()" onkeypress="disableEnterKey(event)"/>
        </div>
        <div class="col-sm-2">
            <label for="alignment-select" class="d-inline-block"><i class="fas fa-align-center"></i></label>
            <div class="d-inline-block">
                <x-adminlte-select name="align" id="alignment-select" onchange="changeTextAlignment()">
                    <x-adminlte-options :options="$align"/>
                </x-adminlte-select>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="d-flex">
                <div class="mr-1">
                    <label for="color-input" class="d-inline-block"><i class="fas fa-fill"></i></label>
                    <div class="d-inline-block">
                        <x-adminlte-input name="color" type="color" value="#000000" id="color-input" onchange="changeTextColor()" style="width:42px"/>
                    </div>
                </div>
                <div class="ml-1">
                    <label for="letter-spacing-input" class="d-inline-block"><i class="fas fa-text-width"></i></label>
                    <div class="d-inline-block">
                        <x-adminlte-input name="spacing" type="number" id="letter-spacing-input" min="0" onchange="changeLetterSpacing()" style="width:70px" onkeypress="disableEnterKey(event)"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <x-adminlte-button type="button" class="btn btn-default px-2" icon="fas fa-font" value="normal" title="Normal" onclick="changeTextStyle(this)"/>
            <x-adminlte-button type="button" class="btn btn-default px-2" icon="fas fa-bold" value="bold" title="Bold" onclick="changeTextStyle(this)"/>
            <x-adminlte-button type="button" class="btn btn-default px-2" icon="fas fa-italic" value="italic" title="Italic" onclick="changeTextStyle(this)"/>
            <x-adminlte-button type="button" class="btn btn-default px-2" icon="fas fa-underline" value="true" title="Underline" onclick="changeTextDecoration(this)"/>
        </div>
        <div class="col-sm-12 mb-2">
            <div class="dropdown">
                <button class="btn btn-default w-100 dropdown-toggle" type="button" data-toggle="dropdown"><span id="selected-font">Select Font</span><span class="caret"></span></button>
                <ul class="dropdown-menu" style="max-height: 250px;overflow-y: auto;">
                    @foreach($fonts as $font)
                        <li><a href="#" data-font="{{ $font }}" style="font-family: {{ $font }}; color: inherit;" onclick="changeTextFontFamily(this,event)">{{ ucfirst(str_replace('_',' ',$font)) }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <div class="add-elements">
        <div class="row">
            <div class="col-md-6 d-flex align-items-stretch">
                <x-adminlte-input name="text" placeholder="Enter Text" id="text-input" onkeypress="disableEnterKey(event)"/>
                <div class="form-group">
                    <x-adminlte-button type="button" theme="primary" icon="fas fa-lg fa-check" title="Add Text" onclick="addText()"/>
                </div>
            </div>
            <div class="col-md-4">
                <x-adminlte-input type="file" name="img" class="file-input" accept="image/*" onchange="addImage()" id="image-input"/>
            </div>
        </div>
    </div>
    <canvas id="canvas" width="700" height="400" class="border"></canvas>
</div>

<input type="hidden" name="template" id="template_canvas"/>
<input type="hidden" name="image" id="template_image"/>
