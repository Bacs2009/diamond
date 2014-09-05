var actions =
{
	page : 2,

	beforeSend : function()
	{
	},

	success : function(answer)
	{
		if(answer.result)
		{
			for(var i = 0; i < answer.data.list.length; i++)
			{
				document.getElementById("actions-column-" + ((i % 4) + 1)).appendChild(actions.createItem(answer.data.list[i]));
			}

			if(answer.data.list.length <= answer.data.count)
			{
				document.getElementById("show-more").style.display = "none";
			}
			else
			{
				actions.page++;
			}
		}
	},

	createItem : function(options)
	{
		var item = document.createElement("div");
		var container = document.createElement("div");
		var imgBlock = document.createElement("div");
		var link = document.createElement("a");
		var preview = document.createElement("img");
		var title = document.createElement("div");

		item.className = "b-offer-item";
		container.className = "b-wrapper";
		imgBlock.className = "b-img";
		link.href = options.href;
		preview.src = options.img;
		preview.alt = "";
		title.className = "b-title";
		title.innerHTML = options.title;

		link.appendChild(preview);
		imgBlock.appendChild(link);
		container.appendChild(imgBlock);
		container.appendChild(title);
		item.appendChild(container);

		return item;
	}

};