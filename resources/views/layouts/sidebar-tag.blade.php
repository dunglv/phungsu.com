@if(isset($__TAG) && $__TAG->count() > 0)
<div class="bl-sc bl-tag bl-tag-t">
    <div class="bl-ct">
        <div class="bl-l">
            <div class="bl-i bl-i-tag">
                @php
                    $a = array('small', 'x-large', 'medium', 'large');
                @endphp
                @foreach($__TAG as $t)
                <a class="<?php echo $a[rand(0, count($a)-1)]; ?>" href="{{ route('ui.tag.detail', $t->slug) }}">{{$t->title}}</a>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif