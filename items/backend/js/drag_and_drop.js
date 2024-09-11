  // Drag and drop children of an element within div defined by id
  let holders_ids = [
    'popup_edit_related_holder',
    // 'col_left',
    'current_image_holder',
  ];




  // copy this function wherever you want to check if holder is visible and contains something. If yes the function is launched
  function dragAndDropSelectors() {
    // console.log('dragAndDropSelectors');
    // add your holder id here

    holders_ids.forEach((holder) => {
      if (
        $('#' + holder + '> *').length > 0 &&
        $('#' + holder).is(':visible')
      ) {
        createSortable('#' + holder);
      }
    });
  }

  function createSortable(selector) {
    var sortable = document.querySelector(selector);
    Draggable.create(sortable.children, {
      type: 'y',
      bounds: sortable,
      edgeResistance: 1,
      onPress: sortablePress,
      onDragStart: sortableDragStart,
      onDrag: sortableDrag,
      liveSnap: sortableSnap,
      onDragEnd: sortableDragEnd,
    });
  }

  function sortablePress() {
    var t = this.target,
      i = 0,
      child = t;
    while ((child = child.previousSibling)) if (child.nodeType === 1) i++;
    t.currentIndex = i;
    t.currentHeight = t.offsetHeight;
    t.kids = [].slice.call(t.parentNode.children); // convert to array
  }

  function sortableDragStart() {
    TweenLite.set(this.target, { color: '#88CE02' });
  }

  function sortableDrag() {
    var t = this.target,
      elements = t.kids.slice(), // clone
      indexChange = Math.round(this.y / t.currentHeight),
      bound1 = t.currentIndex,
      bound2 = bound1 + indexChange;
    if (bound1 < bound2) {
      // moved down
      TweenLite.to(elements.splice(bound1 + 1, bound2 - bound1), 0.15, {
        yPercent: -100,
      });
      TweenLite.to(elements, 0.15, { yPercent: 0 });
    } else if (bound1 === bound2) {
      elements.splice(bound1, 1);
      TweenLite.to(elements, 0.15, { yPercent: 0 });
    } else {
      // moved up
      TweenLite.to(elements.splice(bound2, bound1 - bound2), 0.15, {
        yPercent: 100,
      });
      TweenLite.to(elements, 0.15, { yPercent: 0 });
    }
  }

  function sortableSnap(y) {
    var h = this.target.currentHeight;
    return Math.round(y / h) * h;
  }

  function sortableDragEnd() {
    var t = this.target,
      max = t.kids.length - 1,
      newIndex = Math.round(this.y / t.currentHeight);
    newIndex += (newIndex < 0 ? -1 : 0) + t.currentIndex;
    if (newIndex === max) {
      t.parentNode.appendChild(t);
    } else {
      t.parentNode.insertBefore(t, t.kids[newIndex + 1]);
    }
    TweenLite.set(t.kids, { yPercent: 0, overwrite: 'all' });
    TweenLite.set(t, { y: 0, color: '' });
  }
