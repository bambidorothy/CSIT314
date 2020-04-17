//Constructor function example
function Circle(radius) {//creates a circle obj
    this.radius = radius; //creates a radius property
    this.draw = function () { //creates a draw method
        console.log('draw');
    }
}

const circ = new Circle(1); //creates an instantiation of circle obj