var EiCreditPointSlider = Class.create();
EiCreditPointSlider.prototype = {
    initialize: function(amountR, trackR, handleR, decrHandleR, incrHandleR, minPointR, maxPointR, stepR, labelAmountR, checkMaxAmountR) {
        
        this.minPointsCheck = minPointR;
        this.minPoints = 0;
        this.maxPoints = maxPointR;
        this.pointStep = stepR;
        
        this.amountR = $(amountR);
        this.trackR = $(trackR);
        this.handleR = $(handleR);
        this.labelAmountR = $(labelAmountR);
        this.checkMaxAmountR = $(checkMaxAmountR);
        
        
        this.mwSlider = new Control.Slider(this.handleR, this.trackR, {
            range: $R(this.minPoints, this.maxPoints),
            values: this.mwAvailableValue(),
            onSlide: this.changeCreditPoint.bind(this),  
            onChange: this.changeCreditPoint.bind(this)
        });
        
        this.changeCreditPointCallback = function(v){};
        
        Event.observe($(decrHandleR), 'click', this.decrHandle.bind(this));
        Event.observe($(incrHandleR), 'click', this.incrHandle.bind(this));
    },
    mwAvailableValue: function() {
        var values = [];
        for (var i = this.minPoints; i <= this.maxPoints; i += this.pointStep) {
            values.push(i);
        }
        return values;
    },
    changeCreditPoint: function(points) {
        this.amountR.value = points;
        if (this.labelAmountR) {
            this.labelAmountR.innerHTML = points;
        }
        
        
        if (points == this.maxPoints) {
           if($(this.checkMaxAmountR)) $(this.checkMaxAmountR).checked = true;
        } else {
        	if($(this.checkMaxAmountR)) $(this.checkMaxAmountR).checked = false;
        }
        if (typeof this.changeCreditPointCallback == 'function') {
            this.changeCreditPointCallback(points);
        }
    },
    decrHandle: function() {
        var curVal = this.mwSlider.value - this.pointStep;
        if (curVal >= this.minPoints) {
            this.mwSlider.value = curVal;
            this.mwSlider.setValue(curVal);
            this.changeCreditPoint(curVal);
        }
    },
    incrHandle: function() {
        var curVal = this.mwSlider.value + this.pointStep;
        if (curVal <= this.maxPoints) {
            this.mwSlider.value = curVal;
            this.mwSlider.setValue(curVal);
            this.changeCreditPoint(curVal);
        }
    },
    setPointChange: function(points) {
        points = this.mwSlider.getNearestValue(parseInt(points));
        this.mwSlider.value = points;
        this.mwSlider.setValue(points);
        this.changeCreditPoint(points);
    }
    
}