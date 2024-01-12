@php
$currentLanguage =app()->getLocale();
@endphp

@extends('layouts.panel')
<style>
    body {
        font-family: Arial, sans-serif;
    }
    .menu {
        background-color: #fff;
        color: #1d212f;
        padding: 10px;
        width: 400px;
        margin-top: 25px
    }
    .arabic{
        margin-right: 400px;
    }
    .english{
        margin-left: 400px;
    }
    .menu-item {
        padding: 5px 10px;
        cursor: pointer;
    }
    .supermenu {
        border: 1px solid #e3e3e4;
        margin-bottom: 10px;
    }
</style>

@section('content')
<div class="menu {{ $currentLanguage === 'ar' ? 'arabic' : 'english' }}">
    <form action="{{ route('save-changes') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="supermenu-container" id="sortable-container">
            @foreach ($menus as $menu)
                <div class="supermenu" id="supermenu_{{$menu->id}}">
                    @if(app()->getLocale() === 'ar')
                        &rarr; {{$menu->name_ar}}
                    @else
                        &rarr; {{$menu->name_en}}
                    @endif
                    <input type="hidden" name="menu_positions[{{$menu->id}}]" value="{{$menu->position}}">
                    <div class="submenu-container" id="submenu_{{$menu->id}}">
                        @foreach ($MenuItems as $MenuItem)
                            @if($MenuItem->menu==$menu->id)
                                <div class="menu-item">
                                    @if(app()->getLocale() === 'ar')
                                        {{$MenuItem->label_ar}}
                                    @else
                                        {{$MenuItem->label_en}}
                                    @endif
                                </div>
                                <input type="hidden" id ="sub_menu_position" name="submenu_positions[{{$MenuItem->id}}]" value="{{$MenuItem->position}}">
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        
        <button id="save_btn" type="submit" class="btn btn-primary">{{ trans('web_trans.save_changes') }}</button>
    </form>
    
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sortable for supermenus
        const supermenuContainer = document.querySelector('#sortable-container');

        new Sortable(supermenuContainer, {
            group: 'supermenus',
            animation: 150,
            handle: '.supermenu',
            onStart(evt) {
                evt.from.appendChild(evt.item);
            },
            onEnd: (evt) => {
                const supermenus = Array.from(supermenuContainer.children);
                supermenus.forEach((supermenu, index) => {
                    const supermenuID = supermenu.id.split('_')[1];
                    const positionInput = supermenu.querySelector('input[type="hidden"]');
                    positionInput.value = index + 1;
                });
            },
        });

        // Sortable for submenus within their respective supermenus
        const submenuContainers = document.querySelectorAll('.submenu-container');
        submenuContainers.forEach(container => {
            const supermenuID = container.id.split('_')[1]; // Extract the supermenu ID from the container ID
            new Sortable(container, {
                group: 'submenus_' + supermenuID, // Assign a unique group name for each submenu
                animation: 150,
                handle: '.menu-item',
                swapThreshold: 0.5, // Threshold for swapping
                invertSwap: true, // Will always use inverted swap zone
                direction: 'horizontal', // Specify direction of drag/sort
                onEnd: (evt) => {
                    const submenuContainer = evt.from;
                    const submenuItems = Array.from(submenuContainer.children);
                    submenuItems.forEach((submenuItem, index) => {
                        const submenuID = submenuItem.id.split('_')[1];
                        const positionInput = document.querySelector(`input[name="submenu_positions[${submenuID}]"]`);
                        positionInput.value = index + 1;
                    });
                },
            });
        });
    });
</script>

@endsection
