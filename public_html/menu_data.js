fixMozillaZIndex=true; //Fixes Z-Index problem  with Mozilla browsers but causes odd scrolling problem, toggle to see if it helps
_menuCloseDelay=500;
_menuOpenDelay=150;
_subOffsetTop=0;
_subOffsetLeft=0;

with(menuStyle2=new mm_style()){
fontfamily="Lucida Sans Unicode";
fontsize="11px";
fontstyle="bold";
offcolor="#000000";
oncolor="#000000";
onbgcolor="#e5e5e5";
offbgcolor="#FFFFFF";
padding=0;
borderwidth=0;
separatorsize=1;
separatorcolor="#e5e5e5";
rawcss="margin: 0px; border: 0px; padding-left: 8px; text-align: left;";
itemwidth="160px";
itemheight="17px";
overfilter="Shadow(color='#000000', Direction=138, Strength=4)";
}


with(milonic=new menuname("drivesystems")){
style=menuStyle2;
top=144;
aI("text=ACR&reg; Phillips;url=acr_phillips.php;");
aI("text=ACR&reg; Torq-Set;url=acr_torq-set.php;");
aI("text=HexStix&reg;;url=hexstix.php;");
aI("text=Mortorq&reg;;url=mortorq.php;");
aI("text=Mortorq&reg; Super;url=mortorq_super.php;");
aI("text=Phillips II&reg;;url=phillips_ii.php;");
aI("text=Phillips Square-Driv&reg;;url=phillips_square-driv.php;");
aI("text=PoziDriv&reg;;url=pozidriv.php;");
aI("text=PoziSquare&reg; Driv;url=pozisquare.php;");
aI("text=Torq-Set&reg;;url=torq-set.php;");
aI("text=Tri-Wing&reg;;url=tri-wing.php;");
}

with(milonic=new menuname("about")){
style=menuStyle2;
top=144;
aI("text=Events;url=events.php;");
aI("text=News;url=news.php;");
aI("text=Sitemap;url=sitemap.php;");
}

with(milonic=new menuname("resources")){
style=menuStyle2;
top=144;
aI("text=Head Standards;url=resource_library.php?cat=2;");
aI("text=Brochures;url=resource_library.php?cat=1;");
aI("text=Data Sheets;url=resource_library.php?cat=4;");
aI("text=Video Library;url=resource_library.php?cat=3;");
aI("text=Definition of Terms;url=terminology.php;");
aI("text=Copyright/Trademarks;url=copyright.php;");}

drawMenus();

