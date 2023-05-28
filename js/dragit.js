window.onload = function() {
	var group
	var coordinates = ToolMan.coordinates()
	var drag = ToolMan.drag()

	var boxDrag = document.getElementById("boxDrag")
	drag.createSimpleGroup(boxDrag)

	var boxVerticalOnly = document.getElementById("boxVerticalOnly")
	group = drag.createSimpleGroup(boxVerticalOnly)
	group.verticalOnly()

	var boxHorizontalOnly = document.getElementById("boxHorizontalOnly")
	group = drag.createSimpleGroup(boxHorizontalOnly)
	group.horizontalOnly()

	var boxRegionConstraint = document.getElementById("boxRegionConstraint")
	group = drag.createSimpleGroup(boxRegionConstraint)
	var origin = coordinates.create(0, 0)
	group.addTransform(function(coordinate, dragEvent) {
		var originalTopLeftOffset = 
				dragEvent.topLeftOffset.minus(dragEvent.topLeftPosition)
		return coordinate.constrainTo(origin, originalTopLeftOffset)
	})

	var boxThreshold = document.getElementById("boxThreshold")
	group = drag.createSimpleGroup(boxThreshold)
	group.setThreshold(25)

	var boxHandle = document.getElementById("boxHandle")
	group = drag.createSimpleGroup(boxHandle, document.getElementById("handle"))

	var boxAbsolute = document.getElementById("boxAbsolute")
	group = drag.createSimpleGroup(boxAbsolute)
	group.verticalOnly()
	group.addTransform(function(coordinate, dragEvent) {
		var scrollOffset = coordinates.scrollOffset()
		if (coordinate.y < scrollOffset.y)
			return coordinates.create(coordinate.x, scrollOffset.y)

		var clientHeight = coordinates.clientSize().y
		var boxHeight = coordinates._size(boxAbsolute).y
		if ((coordinate.y + boxHeight) > (scrollOffset.y + clientHeight))
			return coordinates.create(coordinate.x, 
					(scrollOffset.y + clientHeight) - boxHeight)

		return coordinate
	})
}