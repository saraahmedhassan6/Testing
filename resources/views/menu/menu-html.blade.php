<?php
$currentUrl = url()->current();
$currentLanguage =app()->getLocale();

?>
@extends('layouts.panel')
@section('content')
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="{{ asset('assets/style.css') }}" rel="stylesheet">
    
	<div id="hwpwrap">
        <div class="custom-wp-admin wp-admin wp-core-ui js   menu-max-depth-0 nav-menus-php auto-fold admin-bar">
            <div id="wpwrap">
                <div id="wpcontent">
                    <div id="wpbody">
                        <div id="wpbody-content">

                            <div class="wrap">

                                <div class="manage-menus">
                                    <form method="get" action="{{ $currentUrl }}">
                                        <label for="menu"
                                            class="selected-menu">{{ trans('web_trans.Select_label') }}</label>

                                        @php
                                            $menuOptions = [];
                                            $currentLocale = app()->getLocale();
                                            
                                            foreach ($menulist as $menu) {
                                                $menuName = ($currentLocale === 'ar') ? $menu->name_ar : $menu->name_en;
                                                $menuOptions[$menu->id] = $menuName;
                                            }
                                        @endphp
                                        

                                        {!! Menu::select('menu', $menuOptions) !!}


                                        <span class="submit-btn">
                                            <input type="submit" class="button-secondary" value="Choose">
                                        </span>
                                        <span class="add-new-menu-action">{{ trans('web_trans.or') }} <a
                                                href="{{ $currentUrl }}?action=edit&menu=0">{{ trans('web_trans.create_new_menu') }}</a>.
                                        </span>
                                    </form>
                                </div>
                                <div id="nav-menus-frame">

                                    @if (request()->has('menu') && !empty(request()->input('menu')))
                                        <div id="menu-settings-column" class="metabox-holder">

                                            <div class="clear"></div>

                                            <form id="nav-menu-meta" action="{{route('store.sub.menu')}}" class="nav-menu-meta" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="selected_menu_id" value="{{ request('menu') }}">

                                                <div id="side-sortables" class="accordion-container">
                                                    <ul class="outer-border">
                                                        <li class="control-section accordion-section  open add-page"
                                                            id="add-page">
                                                            <h3 class="accordion-section-title hndle" tabindex="0">{{trans('web_trans.custom_label')}} 
                                                                <span class="screen-reader-text">Press return or enter
                                                                    to expand</span></h3>
                                                            <div class="accordion-section-content ">
                                                                <div class="inside">
                                                                    <div class="customlinkdiv" id="customlinkdiv">
                                                                        <p id="menu-item-url-wrap">
                                                                            <label class="howto"
                                                                                for="custom-menu-item-url">
                                                                                <span>URL</span>&nbsp;&nbsp;&nbsp;
                                                                                <input id="custom-menu-item-url"
                                                                                    name="url" type="text"
                                                                                    class="menu-item-textbox "
                                                                                    placeholder="url">
                                                                            </label>
                                                                        </p>

                                                                        <p id="menu-item-name-wrap">
                                                                            <label class="howto"
                                                                                for="custom-menu-item-name">
                                                                                <span>{{trans('web_trans.label_in_en')}} </span>&nbsp;
                                                                                <input id="custom-menu-item-name"
                                                                                    name="label_en" type="text"
                                                                                    class="regular-text menu-item-textbox input-with-default-title"
                                                                                    title="Label menu">
                                                                            </label>
                                                                            <label class="howto"
                                                                                for="custom-menu-item-name">
                                                                                <span>{{trans('web_trans.label_in_ar')}} </span>&nbsp;
                                                                                <input id="custom-menu-item-name"
                                                                                    name="label_ar" type="text"
                                                                                    class="regular-text menu-item-textbox input-with-default-title"
                                                                                    title="Label menu">
                                                                            </label>
                                                                        </p>

                                                                        @if (!empty($roles))
                                                                            <p id="menu-item-role_id-wrap">
                                                                                <label class="howto"
                                                                                    for="custom-menu-item-name">
                                                                                    <span>Role</span>&nbsp;
                                                                                    <select id="custom-menu-item-role"
                                                                                        name="role">
                                                                                        <option value="0">Select Role
                                                                                        </option>
                                                                                        @foreach ($roles as $role)
                                                                                            <option
                                                                                                value="{{ $role->$role_pk }}">
                                                                                                {{ ucfirst($role->$role_title_field) }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </label>
                                                                            </p>
                                                                        @endif

                                                                        <p class="button-controls">

                                                                            <button href="#" onclick="addcustommenu()"
                                                                                class="button-secondary submit-add-to-menu right">{{trans('web_trans.submenu_btn')}}</button>
                                                                            <span class="spinner" id="spincustomu"></span>
                                                                        </p>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </form>

                                        </div>
                                    @endif
                                    <div id="menu-management-liquid">
                                        <div id="menu-management">
                                            <form id="update-nav-menu" action="{{ route('store.menu') }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="menu-edit ">
                                                    <div id="nav-menu-header">
                                                        <div class="major-publishing-actions">
                                                            <label class="menu-name-label howto open-label" for="menu-name">
                                                                <span>{{ trans('web_trans.name_en') }}</span>
                                                                <input name="menu_name_en" id="menu-name" type="text"
                                                                    class="menu-name regular-text menu-item-textbox"
                                                                    title="Enter menu name"
                                                                    value="@if (isset($indmenu)) {{ $indmenu->name }} @endif">
                                                                <br>
                                                                <label class="menu-name-label howto open-label"
                                                                    for="menu-name_ar">
                                                                    <span>{{ trans('web_trans.name_ar') }}</span>
                                                                    <input name="menu_name_ar" id="menu-name_ar" type="text"
                                                                        class="menu-name regular-text menu-item-textbox"
                                                                        title="Enter menu name"
                                                                        value="@if (isset($indmenu)) {{ $indmenu->name }} @endif">
                                                                    <input type="hidden" id="idmenu"
                                                                        value="@if (isset($indmenu)) {{ $indmenu->id }} @endif" />
                                                                </label>

                                                                @if (request()->has('action'))
                                                                    <div class="publishing-action">
                                                                        <button onclick="createnewmenu()" name="save_menu"
                                                                            id="save_menu_header"
                                                                            class="button button-primary menu-save">{{ trans('web_trans.create_menue') }}</button>
                                                                    </div>
                                                                @elseif(request()->has('menu'))
                                                                    <div class="publishing-action">
                                                                        <a onclick="getmenus()" name="save_menu"
                                                                            id="save_menu_header"
                                                                            class="button button-primary menu-save">{{ trans('web_trans.save') }}</a>
                                                                        <span class="spinner" id="spincustomu2"></span>
                                                                    </div>
                                                                @else
                                                                    <div class="publishing-action">
                                                                        <button onclick="createnewmenu()" name="save_menu"
                                                                            id="save_menu_header"
                                                                            class="button button-primary menu-save">{{ trans('web_trans.create_menue') }}</button>
                                                                    </div>
                                                                @endif
                                                        </div>
                                                    </div>
                                                    <div id="post-body">
                                                        <div id="post-body-content">

                                                            @if (request()->has('menu'))
                                                                <h3>{{ trans('web_trans.structure') }}</h3>
                                                                <div class="drag-instructions post-body-plain"
                                                                    style="">
                                                                    <p>
                                                                        {{ trans('web_trans.check_item') }}
                                                                    </p>
                                                                </div>
                                                            @else
                                                                <h3>{{ trans('web_trans.Menu_Creation') }}</h3>
                                                                <div class="drag-instructions post-body-plain"
                                                                    style="">
                                                                    <p>
                                                                        {{ trans('web_trans.enter_name_select') }}
                                                                    </p>
                                                                </div>
                                                            @endif

                                                            <ul class="menu ui-sortable" id="menu-to-edit">
                                                                @if (isset($menus))
                                                                    @foreach ($menus as $m)
                                                                        <li id="menu-item-{{ $m->id }}"
                                                                            class="menu-item menu-item-depth-{{ $m->depth }} menu-item-page menu-item-edit-inactive pending"
                                                                            style="display: list-item;">
                                                                            <dl class="menu-item-bar">
                                                                                <dt class="menu-item-handle">
                                                                                    <span class="item-title"> <span
                                                                                            class="menu-item-title"> <span
                                                                                                id="menutitletemp_{{ $m->id }}">{{ $m->label }}</span>
                                                                                            <span
                                                                                                style="color: transparent;">|{{ $m->id }}|</span>
                                                                                        </span> <span class="is-submenu"
                                                                                            style="@if ($m->depth == 0) display: none; @endif">Subelement</span>
                                                                                    </span>
                                                                                    <span class="item-controls"> <span
                                                                                            class="item-type">Link</span>
                                                                                        <span
                                                                                            class="item-order hide-if-js">
                                                                                            <a href="{{ $currentUrl }}?action=move-up-menu-item&menu-item={{ $m->id }}&_wpnonce=8b3eb7ac44"
                                                                                                class="item-move-up"><abbr
                                                                                                    title="Move Up">↑</abbr></a>
                                                                                            | <a href="{{ $currentUrl }}?action=move-down-menu-item&menu-item={{ $m->id }}&_wpnonce=8b3eb7ac44"
                                                                                                class="item-move-down"><abbr
                                                                                                    title="Move Down">↓</abbr></a>
                                                                                        </span> <a class="item-edit"
                                                                                            id="edit-{{ $m->id }}"
                                                                                            title=" "
                                                                                            href="{{ $currentUrl }}?edit-menu-item={{ $m->id }}#menu-item-settings-{{ $m->id }}">
                                                                                        </a> </span>
                                                                                </dt>
                                                                            </dl>

                                                                            <div class="menu-item-settings"
                                                                                id="menu-item-settings-{{ $m->id }}">
                                                                                <input type="hidden"
                                                                                    class="edit-menu-item-id"
                                                                                    name="menuid_{{ $m->id }}"
                                                                                    value="{{ $m->id }}" />
                                                                                <p class="description description-thin">
                                                                                    <label
                                                                                        for="edit-menu-item-title-{{ $m->id }}">
                                                                                        Label
                                                                                        <br>
                                                                                        <input type="text"
                                                                                            id="idlabelmenu_{{ $m->id }}"
                                                                                            class="widefat edit-menu-item-title"
                                                                                            name="idlabelmenu_{{ $m->id }}"
                                                                                            value="{{ $m->label }}">
                                                                                    </label>
                                                                                </p>

                                                                                <p
                                                                                    class="field-css-classes description description-thin">
                                                                                    <label
                                                                                        for="edit-menu-item-classes-{{ $m->id }}">
                                                                                        Class CSS (optional)
                                                                                        <br>
                                                                                        <input type="text"
                                                                                            id="clases_menu_{{ $m->id }}"
                                                                                            class="widefat code edit-menu-item-classes"
                                                                                            name="clases_menu_{{ $m->id }}"
                                                                                            value="{{ $m->class }}">
                                                                                    </label>
                                                                                </p>

                                                                                <p
                                                                                    class="field-css-url description description-wide">
                                                                                    <label
                                                                                        for="edit-menu-item-url-{{ $m->id }}">
                                                                                        Url
                                                                                        <br>
                                                                                        <input type="text"
                                                                                            id="url_menu_{{ $m->id }}"
                                                                                            class="widefat code edit-menu-item-url"
                                                                                            id="url_menu_{{ $m->id }}"
                                                                                            value="{{ $m->link }}">
                                                                                    </label>
                                                                                </p>

                                                                                @if (!empty($roles))
                                                                                    <p
                                                                                        class="field-css-role description description-wide">
                                                                                        <label
                                                                                            for="edit-menu-item-role-{{ $m->id }}">
                                                                                            Role
                                                                                            <br>
                                                                                            <select
                                                                                                id="role_menu_{{ $m->id }}"
                                                                                                class="widefat code edit-menu-item-role"
                                                                                                name="role_menu_[{{ $m->id }}]">
                                                                                                <option value="0">
                                                                                                    Select Role</option>
                                                                                                @foreach ($roles as $role)
                                                                                                    <option
                                                                                                        @if ($role->id == $m->role_id) selected @endif
                                                                                                        value="{{ $role->$role_pk }}">
                                                                                                        {{ ucwords($role->$role_title_field) }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </label>
                                                                                    </p>
                                                                                @endif

                                                                                <p
                                                                                    class="field-move hide-if-no-js description description-wide">
                                                                                    <label> <span>Move</span> <a
                                                                                            href="{{ $currentUrl }}"
                                                                                            class="menus-move-up"
                                                                                            style="display: none;">Move
                                                                                            up</a> <a
                                                                                            href="{{ $currentUrl }}"
                                                                                            class="menus-move-down"
                                                                                            title="Mover uno abajo"
                                                                                            style="display: inline;">Move
                                                                                            Down</a> <a
                                                                                            href="{{ $currentUrl }}"
                                                                                            class="menus-move-left"
                                                                                            style="display: none;"></a> <a
                                                                                            href="{{ $currentUrl }}"
                                                                                            class="menus-move-right"
                                                                                            style="display: none;"></a> <a
                                                                                            href="{{ $currentUrl }}"
                                                                                            class="menus-move-top"
                                                                                            style="display: none;">Top</a>
                                                                                    </label>
                                                                                </p>

                                                                                <div
                                                                                    class="menu-item-actions description-wide submitbox">

                                                                                    <a class="item-delete submitdelete deletion"
                                                                                        id="delete-{{ $m->id }}"
                                                                                        href="{{ $currentUrl }}?action=delete-menu-item&menu-item={{ $m->id }}&_wpnonce=2844002501">Delete</a>
                                                                                    <span class="meta-sep hide-if-no-js"> |
                                                                                    </span>
                                                                                    <a class="item-cancel submitcancel hide-if-no-js button-secondary"
                                                                                        id="cancel-{{ $m->id }}"
                                                                                        href="{{ $currentUrl }}?edit-menu-item={{ $m->id }}&cancel=1424297719#menu-item-settings-{{ $m->id }}">Cancel</a>
                                                                                    <span class="meta-sep hide-if-no-js"> |
                                                                                    </span>
                                                                                    <button onclick="getmenus()"
                                                                                        class="button button-primary updatemenu"
                                                                                        id="update-{{ $m->id }}"
                                                                                        href="javascript:void(0)">Update
                                                                                        item</button>

                                                                                </div>

                                                                            </div>
                                                                            <ul class="menu-item-transport"></ul>
                                                                        </li>
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                            <div class="menu-settings">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="nav-menu-footer">
                                                        <div class="major-publishing-actions">

                                                            @if (request()->has('action'))
                                                                <div class="publishing-action">
                                                                    <button onclick="createnewmenu()" name="save_menu"
                                                                        id="save_menu_header"
                                                                        class="button button-primary menu-save">{{ trans('web_trans.create_menue') }}</button>
                                                                </div>
                                                            @elseif(request()->has('menu'))
                                                                <span class="delete-action"> <a
                                                                        class="submitdelete deletion menu-delete"
                                                                        onclick="deletemenu()"
                                                                        href="javascript:void(9)">Delete menu</a> </span>
                                                                <div class="publishing-action">

                                                                    <button onclick="getmenus()" name="save_menu"
                                                                        id="save_menu_header"
                                                                        class="button button-primary menu-save">{{ trans('web_trans.save') }}</button>
                                                                    <span class="spinner" id="spincustomu2"></span>
                                                                </div>
                                                            @else
                                                                <div class="publishing-action">
                                                                    <button onclick="createnewmenu()" name="save_menu"
                                                                        id="save_menu_header"
                                                                        class="button button-primary menu-save">{{ trans('web_trans.create_menue') }}</button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clear"></div>
                        </div>

                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
        </div>
    </div>
    
@endsection

