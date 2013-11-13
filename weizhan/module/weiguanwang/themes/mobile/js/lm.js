function lmcard( cid )
{
	lmswith( cid , 'card' );
	current_lmc=cid;
}

function lmtab( tid )
{
	lmswith( tid , 'tab' );
}

function lmswith( id , name )
{
	$(".LM-"+name).each( function( index , value )
	{
		if($(this).attr('id') == id )
		{
			$(this).addClass('cur');
		}
		else
		{
			$(this).removeClass('cur');
		}
	});
}