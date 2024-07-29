/**
 * @file: caydonvi.js
 * @author: npbnguyen@gmail.com
 * @date: 25-09-2014
 * @company : http://dnict.vn
 **/
var createTreeviewInMenuBar = function(text_menu){
	var str = '<ul class="nav nav-pills nav-sidebar flex-column sidebar-menu tree">';
		str+= '<li id="li_tree_parents" class="nav-item">';
		str+= '<a class="nav-link active menu-open sidebar-menu " href="#">';
		str+= '<i class="nav-icon fa fa-sitemap"></i>';
		str+= '<p class="">'+text_menu+'<i class="right fa fa-angle-down"></i></p>';
		// str+= '<i class="right fa fa-angle-down"></i>';
		str+= '</a>';
		str+= '<ul class="nav nav-pills nav-sidebar flex-column">';
		str+= '<li id="li_tree_child" class="nav-item">';
		str+= '<div id="main-content-tree"></div>';
		str+= '</li>';
		str+= '</ul>';
		str+= '</li>';
		str+= '</ul>';
	jQuery('#main-tree').prepend(str);
};

// var createTreeviewInMenuBar = function(text_menu){
// 	var str = '<ul class="nav nav-list">';
// 		str+= '<li id="li_tree_parents" class="open active">';
// 		str+= '<a class="dropdown-toggle" href="#">';
// 		str+= '<i class="icon-sitemap"></i>';
// 		str+= '<span class="menu-text">'+text_menu+'</span>';
// 		str+= '<b class="arrow icon-angle-down"></b>';
// 		str+= '</a>';
// 		str+= '<ul class="submenu open">';
// 		str+= '<li id="li_tree_child" class="open active">';
// 		str+= '<div id="main-content-tree"></div>';
// 		str+= '</li>';
// 		str+= '</ul>';
// 		str+= '</li>';
// 		str+= '</ul>';
// 	jQuery('#main-tree').prepend(str);

// };