let runners = [];

function setup() {
  createCanvas(800, 800);
  // Create objects
  for (var i=0; i<50; i++) {
    let y = random(width);
    let b = new Runner(0, y, 10, "Jean");
    runners.push(b);
  }
}

function mousePressed() {
  for (let i = 0; i < runners.length; i++) {
    runners[i].clicked(mouseX, mouseY);
  }
}


function draw() {
  background(50, 89, 100);
    for (var i=0; i<runners.length; i++) {
      runners[i].move();
      runners[i].display();
    }
}


class Runner {

  constructor(x, y, r, name) {
    this.speed = random(1,3);
    this.name = name;
    this.x = x;
    this.y = y;
    this.r = r;
    this.brightness = 0;
  }

  clicked(px, py) {
    let d = dist(px, py, this.x, this.y);
    if (d < this.r) {
      this.brightness = 255;
      console.log("vous avez cliquez sur " + this.name);
    }
  }

  move() {
    this.x += this.speed;

  }

  display() {
    stroke(255);
    strokeWeight(4);
    fill(this.brightness, 125);
    ellipse(this.x, this.y, this.r * 2);
  }
}
