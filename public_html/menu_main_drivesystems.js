fixMozillaZIndex=true; //Fixes Z-Index problem  with Mozilla browsers but causes odd scrolling problem, toggle to see if it helps
_menuCloseDelay=500;
_menuOpenDelay=150;
_subOffsetTop=0;
_subOffsetLeft=0;


with(menuStyle=new mm_style()){
borderwidth=0;
separatorsize=0;
padding=0;
rawcss="margin: 0px; border: 0px; padding: 0px; text-align: left;";
}

with(milonic=new menuname("Main Menu")){
alwaysvisible=1;
orientation="horizontal";
style=menuStyle;
position="relative";
aI("showmenu=drivesystems;url=wizard.php?v=2;image=images/mn_drivesystems2.jpg;overimage=images/mn_drivesystems2.jpg;itemwidth=150;itemheight=26;");
aI("showmenu=resources;url=resource_library.php;image=images/mn_resource_library1.jpg;overimage=images/mn_resource_library2.jpg;itemwidth=148;itemheight=26;");
aI("url=global_quality.php;image=images/mn_global_quality1.jpg;overimage=images/mn_global_quality2.jpg;itemwidth=148;itemheight=26;");
aI("url=wrentham_tool_group.php;image=images/mn_wrentham1.jpg;overimage=images/mn_wrentham2.jpg;itemwidth=148;itemheight=26;");
aI("url=about_us.php;showmenu=about;image=images/mn_about1.jpg;overimage=images/mn_about2.jpg;itemwidth=148;itemheight=26;");
aI("text=<img src=images/mn_spacer.jpg border=0 width=201 height=26>;itemwidth=201;itemheight=26;");
}

drawMenus();

