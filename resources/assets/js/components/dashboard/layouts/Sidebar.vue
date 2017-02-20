<template>
    <nav id="sidebar">
        <!-- Sidebar Scroll Container -->
        <div id="sidebar-scroll">
            <!-- Sidebar Content -->
            <!-- Adding .sidebar-mini-hide to an element will hide it when the sidebar is in mini mode -->
            <div class="sidebar-content">
                <!-- Side Header -->
                <div class="side-header side-content bg-white-op">
                    <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close">
                        <i class="fa fa-times"></i>
                    </button>
                    <a class="h5 text-white" href="index.html">
                        <img src="/img/logo-sm.png" alt="kapeter">
                        <span class="h4 sidebar-mini-hide">KAPETER</span>
                    </a>
                </div>
                <!-- END Side Header -->

                <!-- Side Content -->
                <div class="side-content">
                    <ul class="nav-main">
                        <li>
                            <a href="base_pages_dashboard.html"><i class="si si-speedometer"></i><span class="sidebar-mini-hide">Dashboard</span></a>
                        </li>
                        <li class="nav-main-heading"><span class="sidebar-mini-hide">User Interface</span></li>
                        <li>
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-badge"></i><span class="sidebar-mini-hide">UI Elements</span></a>
                            <ul>
                                <li>
                                    <a href="base_ui_widgets.html">Widgets</a>
                                </li>
                                <li>
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#">Blocks</a>
                                    <ul>
                                        <li>
                                            <a href="base_ui_blocks.html">Styles</a>
                                        </li>
                                        <li>
                                            <a href="base_ui_blocks_api.html">Blocks API</a>
                                        </li>
                                        <li>
                                            <a href="base_ui_blocks_draggable.html">Draggable</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="base_ui_grid.html">Grid</a>
                                </li>
                                <li>
                                    <a href="base_ui_typography.html">Typography</a>
                                </li>
                                <li>
                                    <a href="base_ui_icons.html">Icons</a>
                                </li>
                                <li>
                                    <a href="base_ui_buttons.html">Buttons</a>
                                </li>
                                <li>
                                    <a href="base_ui_activity.html">Activity</a>
                                </li>
                                <li>
                                    <a href="base_ui_tabs.html">Tabs</a>
                                </li>
                                <li>
                                    <a href="base_ui_tiles.html">Tiles</a>
                                </li>
                                <li>
                                    <a href="base_ui_cards.html">Cards</a>
                                </li>
                                <li>
                                    <a href="base_ui_ribbons.html">Ribbons</a>
                                </li>
                                <li>
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#">Chat</a>
                                    <ul>
                                        <li>
                                            <a href="base_ui_chat_full.html">Full</a>
                                        </li>
                                        <li>
                                            <a href="base_ui_chat_fixed.html">Fixed</a>
                                        </li>
                                        <li>
                                            <a href="base_ui_chat_popup.html">Popup</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#">Timeline</a>
                                    <ul>
                                        <li>
                                            <a href="base_ui_timeline.html">Various</a>
                                        </li>
                                        <li>
                                            <a href="base_ui_timeline_social.html">Social</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="base_ui_navigation.html">Navigation</a>
                                </li>
                                <li>
                                    <a href="base_ui_modals_tooltips.html">Modals &amp; Tooltips</a>
                                </li>
                                <li>
                                    <a href="base_ui_color_themes.html">Color Themes</a>
                                </li>
                            </ul>
                    </ul>
                </div>
                <!-- END Side Content -->
            </div>
            <!-- Sidebar Content -->
        </div>
        <!-- END Sidebar Scroll Container -->
    </nav>
</template>

<script>
   import menus from '../../../config/menus.js'

    export default {
        data () {
            return {
                menus: menus,
            }
        },

    }
</script>

<style>
</style>