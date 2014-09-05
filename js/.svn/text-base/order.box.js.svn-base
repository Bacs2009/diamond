function OrderBox(ID)
{
	var T=this;
	this.Box=null;
	this.OldMouseMove=null;
	this.OldMouseUp=null;
	this.Selected=null;
	this.Moving=null;
	this.Selected=null;
	this.SelectedI=0;
	this.SelectedJ=0;
	this.FixedX=0;
	this.FixedY=0;
	this.Grid=[];

	this.Init=function(ID)
	{
		var i,Items;
		this.Box=this.GID(ID);
		if(!this.Box) return false;

		Items=this.Box.getElementsByTagName("li");
		for(i=0;i<Items.length;i++)
		{
			Items[i].onmousedown=function(E){ return T.FixElement(this,E || window.event); };
		}

		this.FillGrid();
	};

	this.FixElement=function(Obj,E)
	{
		if(typeof(document.onmousemove)!=="function") document.onmousemove=function(E){ T.MoveSelected(E || window.event); };
		else
		{
			T.OldMouseMove=document.onmousemove;
			document.onmousemove=function(E)
			{
				T.MoveSelected(E || window.event);
				T.OldMouseMove();
			};
		}

		if(typeof(document.onmouseup)!=="function") document.onmouseup=function(){ T.DropSelected(); };
		else
		{
			T.OldMouseUp=document.onmouseup;
			document.onmouseup=function()
			{
				T.DropSelected();
				T.OldMouseUp();
			};
		}

		document.ondragstart=function(){ return false; };
		document.body.onselectstart=function(){ return false; };

		this.Moving=Obj;
		this.Selected=this.Moving.cloneNode(true);
		this.Box.insertBefore(this.Selected,this.Moving);

		this.Selected.style.visibility="hidden";
		this.Moving.style.position="absolute";
		this.Moving.style.left=this.Selected.offsetLeft+"px";
		this.Moving.style.top=this.Selected.offsetTop+"px";

		this.FixedX=E.clientX-this.Box.offsetLeft-this.Selected.offsetLeft;
		this.FixedY=E.clientY-this.Box.offsetTop-this.Selected.offsetTop;

		this.DefineSelected();

		return false;
	};

	this.DropSelected=function()
	{
		document.onmousemove=this.OldMouseMove;
		document.onmouseup=this.OldMouseUp;
		document.ondragstart=null;
		document.body.onselectstart=null;

		this.Box.replaceChild(this.Moving,this.Selected);
		this.Grid[this.SelectedJ][this.SelectedI]=this.Moving;
		this.Moving.style.position="static";
		this.Selected=null;
		this.Moving=null;
	};

	this.MoveSelected=function(E)
	{
		var i,j;
		var OffsetX=E.clientX-this.Box.offsetLeft-this.FixedX;
		var OffsetY=E.clientY-this.Box.offsetTop-this.FixedY;
		var CenterX,CenterY;

		this.Moving.style.left=OffsetX+"px";
		this.Moving.style.top=OffsetY+"px";

		for(j=this.SelectedJ-1;j<=this.SelectedJ+1;j++)
		{
			for(i=this.SelectedI-1;i<=this.SelectedI+1;i++)
			{
				if(this.Grid[j] && this.Grid[j][i] && (i!=this.SelectedI || j!=this.SelectedJ))
				{
					CenterX=OffsetX+Math.floor(this.Selected.offsetWidth/2);
					CenterY=OffsetY+Math.floor(this.Selected.offsetHeight/2);

					if
					(
						CenterX<this.Grid[j][i].offsetLeft+this.Grid[j][i].offsetWidth && CenterX>this.Grid[j][i].offsetLeft+Math.floor(this.Grid[j][i].offsetWidth/2) &&
						CenterY>this.Grid[j][i].offsetTop && CenterY<this.Grid[j][i].offsetTop+this.Grid[j][i].offsetHeight && !(this.SelectedJ-1==j && i==this.Grid[j].length-1)
					)
					{
						if(j==this.SelectedJ)
						{
							this.Box.insertBefore(this.Selected,this.Grid[j][i]);
							this.Box.insertBefore(this.Moving,this.Grid[j][i]);
						}
						else
						{
							this.Box.insertBefore(this.Selected,this.Grid[j][i].nextSibling);
							this.Box.insertBefore(this.Moving,this.Selected);
						}
						this.FillGrid();
						this.DefineSelected();
						return true;
					}

					if
					(
						CenterX>this.Grid[j][i].offsetLeft && CenterX<this.Grid[j][i].offsetLeft+Math.floor(this.Grid[j][i].offsetWidth/2) &&
						CenterY>this.Grid[j][i].offsetTop && CenterY<this.Grid[j][i].offsetTop+this.Grid[j][i].offsetHeight && !(this.SelectedJ+1==j && i==0)
					)
					{
						if(j==this.SelectedJ)
						{
							this.Box.insertBefore(this.Selected,this.Grid[j][i].nextSibling);
							this.Box.insertBefore(this.Moving,this.Grid[j][i].nextSibling);
						}
						else
						{
							this.Box.insertBefore(this.Selected,this.Grid[j][i]);
							this.Box.insertBefore(this.Moving,this.Grid[j][i]);
						}
						this.FillGrid();
						this.DefineSelected();
						return true;
					}
				}
			}
		}
	};

	this.FillGrid=function()
	{
		var i,Items,Top=0,Row=new Array();

		this.Grid=[];

		Items=this.Box.getElementsByTagName("li");
		for(i=0;i<Items.length;i++)
		{
			if(!this.Moving || this.Moving!=Items[i])
			{
				if(Items[i].offsetTop != Top)
				{
					this.Grid.push(Row);
					Row=[];
					Top=Items[i].offsetTop;
				}
				Row.push(Items[i]);
			}
		}

		if(Row.length) this.Grid.push(Row);
	};

	this.DefineSelected=function()
	{
		var i,j;

		for(j=0;j<this.Grid.length;j++)
		{
			for(i=0;i<this.Grid[j].length;i++)
			{
				if(this.Grid[j][i] == this.Moving || this.Grid[j][i] == this.Selected)
				{
					this.SelectedI=i;
					this.SelectedJ=j;
					return true;
				}
			}
		}
	};

	this.GID=function(ID)
	{
		return document.getElementById(ID);
	};

	this.Init(ID);
}