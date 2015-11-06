package com.finaonation.utils;

import android.content.Context;
import android.util.AttributeSet;
import android.view.MotionEvent;
import android.widget.ListView;

public class Finaolistview extends ListView{

	 private float xDistance, yDistance, lastX, lastY;

	    // If built programmatically
	    public Finaolistview(Context context) {
	        super(context);
	        // init();
	    }

	    // This example uses this method since being built from XML
	    public Finaolistview(Context context, AttributeSet attrs) {
	        super(context, attrs);
	        // init();
	    }

	    // Build from XML layout
	    public Finaolistview(Context context, AttributeSet attrs, int defStyle) {
	        super(context, attrs, defStyle);
	        // init();
	    }
//	    @Override
//	    public boolean dispatchTouchEvent(MotionEvent ev){
//	       if(ev.getAction()==MotionEvent.ACTION_MOVE)
//	          return true;
//	       return super.dispatchTouchEvent(ev);
//	    }
	    @Override
	    public boolean onInterceptTouchEvent(MotionEvent ev) {

	        switch (ev.getAction()) {
	        case MotionEvent.ACTION_DOWN:
	            xDistance = yDistance = 0f;
	            lastX = ev.getX();
	            lastY = ev.getY();
	            break;
	        case MotionEvent.ACTION_MOVE:
	            final float curX = ev.getX();
	            final float curY = ev.getY();
	            xDistance += Math.abs(curX - lastX);
	            yDistance += Math.abs(curY - lastY);
	            lastX = curX;
	            lastY = curY;
	            if (xDistance > yDistance)
	                return false;
	        }

	        return super.onInterceptTouchEvent(ev);

	    }

}
