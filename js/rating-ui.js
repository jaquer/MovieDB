function selectStar(oStar, iValue) {

	oParent = oStar.parentNode;
	aStar   = oParent.getElementsByTagName('img');
	aInput  = oParent.getElementsByTagName('input');

	if (iValue == -1)
		aInput[6].checked = true;
	else
		aInput[iValue].checked = true;

	if (iValue == 0)
		aStar[0].src = '/moviedb/images/not-interested.png';
	else
		aStar[0].src = '/moviedb/images/not-interested-off.png';

	for (i = 1; i <= 5; i++)
		if (i <= iValue)
			aStar[i].src = '/moviedb/images/star.png';
		else
			aStar[i].src = '/moviedb/images/star-off.png';

}
