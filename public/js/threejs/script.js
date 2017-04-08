var Colors = {
	red:0xf25346,
	white:0xd8d0d1,
	brown:0x59332e,
	pink:0xF5986E,
	brownDark:0x23190f,
	blue:0x68c3c0
}


window.addEventListener('load', init, false);

function init(){
	createScene();
	createLights();
	createSea();
	createSky();

	renderer.render(scene, camera);
}


var scene,camera,renderer,WIDTH,HEIGHT;
function createScene(){
	
	WIDTH = window.innerWidth;
	HEIGHT = window.innerHeight;

	FieldOfView = 60;
	aspectRatio = WIDTH/HEIGHT;
	nearPlane = 1;
	farPlane = 10000;


	scene = new THREE.Scene();

	scene.fog = new THREE.Fog(0xf7d9aa,1,500);

	//Create camera

	camera = new THREE.PerspectiveCamera(FieldOfView,aspectRatio,nearPlane,farPlane);

	camera.position.x = 0;
	camera.position.y=100;
	camera.position.z = 200;

	renderer = new THREE.WebGLRenderer({alpha:true,antialias:true});

	renderer.setSize(WIDTH,HEIGHT);

	renderer.shadowMap.enabled= true;

	container = document.getElementById('world');

	container.appendChild(renderer.domElement);

}

//Create Light

var hemisphereLight ,shadowLight;

function createLights(){
	hemisphereLight = new THREE.HemisphereLight(0xaaaaaa,0x000000,.9);

	shadowLight = new THREE.DirectionalLight(0x000000,.9);

	shadowLight.position.set(150,350,350);

	shadowLight.castShadow = true;

	shadowLight.shadow.camera.left = -400;
	shadowLight.shadow.camera.right = 400;
	shadowLight.shadow.camera.top = 400;
	shadowLight.shadow.camera.bottom = -400;
	shadowLight.shadow.camera.near = 1;
	shadowLight.shadow.camera.far = 1000;

	// define the resolution of the shadow; the higher the better, 
	// but also the more expensive and less performant
	shadowLight.shadow.mapSize.width = 2048;
	shadowLight.shadow.mapSize.height = 2048;

	scene.add(hemisphereLight);  
	scene.add(shadowLight);
}




Sea = function(){
	var geom = new THREE.CylinderGeometry(600,600,800,40,10);

	geom.applyMatrix(new THREE.Matrix4().makeRotationX(-Math.PI/2));

	var mat = new THREE.MeshPhongMaterial({color:Colors.blue,transparent:true,opacity:.6,shading:THREE.FlatShading});

	this.mesh = new THREE.Mesh(geom,mat);	
}

var sea;
function createSea(){
	sea = new Sea();

	sea.mesh.position.y = -600;
	scene.add(sea.mesh);
}

Cloud = function(){

	this.mesh = new THREE.Object3D();

	var geom = new THREE.BoxGeometry(20,20,20);

	var mat = new THREE.MeshPhongMaterial({color:Colors.white});

	var nBlocs = 3 + Math.floor(Math.random() *3);
	

	for(var  i= 0; i < nBlocs ; i++){
		var m = new THREE.Mesh(geom,mat);

		/*m.position.x = i*15;
		m.position.y = Math.random() *10;

		m.position.z = Math.random() * Math.PI *2;*/

		m.position.x = i*15;
		m.position.y = Math.random()*10;
		m.position.z = Math.random()*10;
		m.rotation.z = Math.random()*Math.PI*2;
		m.rotation.y = Math.random()*Math.PI*2;

		var s =.1 + Math.random() * .9;

		m.scale.set(s,s,s);
		m.castShadow = true;

		m.receiveShadow = true;

		this.mesh.add(m);

	}
}

Sky = function(){
	this.mesh = new THREE.Object3D();

	this.nClouds = 20;

	var stepAngle = Math.PI *2 / this.nClouds;

	//create the clouds

	for(var i=0 ; i< this.nClouds ;i ++){
		var c = new Cloud();

		var a = stepAngle * i;

		var h = 750 + Math.random() * 200;

		c.mesh.position.x = Math.cos(a) *h;
		c.mesh.position.y = Math.sin(a) *h;

		//rotate cloud according to its position

		c.mesh.rotation.z = a + Math.PI/2 ;

		c.mesh.position.z = -400-Math.random()*400;

		//set random scale for each cloud

		var s = 1 + Math.random() *2;
		c.mesh.scale.set(s,s,s);

		this.mesh.add(c.mesh);
	}

}

var sky;

function createSky(){
	sky = new Sky();
	sky.mesh.position.y = -600;
	scene.add(sky.mesh);
}


/*Cloud = function(){
	// Create an empty container that will hold the different parts of the cloud
	this.mesh = new THREE.Object3D();
	
	// create a cube geometry;
	// this shape will be duplicated to create the cloud
	var geom = new THREE.BoxGeometry(20,20,20);
	
	// create a material; a simple white material will do the trick
	var mat = new THREE.MeshPhongMaterial({
		color:Colors.white,  
	});
	
	// duplicate the geometry a random number of times
	var nBlocs = 3+Math.floor(Math.random()*3);
	for (var i=0; i<nBlocs; i++ ){
		
		// create the mesh by cloning the geometry
		var m = new THREE.Mesh(geom, mat); 
		
		// set the position and the rotation of each cube randomly
		m.position.x = i*15;
		m.position.y = Math.random()*10;
		m.position.z = Math.random()*10;
		m.rotation.z = Math.random()*Math.PI*2;
		m.rotation.y = Math.random()*Math.PI*2;
		
		// set the size of the cube randomly
		var s = .1 + Math.random()*.9;
		m.scale.set(s,s,s);
		
		// allow each cube to cast and to receive shadows
		m.castShadow = true;
		m.receiveShadow = true;
		
		// add the cube to the container we first created
		this.mesh.add(m);
	} 
}

Sky = function(){
	// Create an empty container
	this.mesh = new THREE.Object3D();
	
	// choose a number of clouds to be scattered in the sky
	this.nClouds = 20;
	
	// To distribute the clouds consistently,
	// we need to place them according to a uniform angle
	var stepAngle = Math.PI*2 / this.nClouds;
	
	// create the clouds
	for(var i=0; i<this.nClouds; i++){
		var c = new Cloud();
	 
		// set the rotation and the position of each cloud;
		// for that we use a bit of trigonometry
		var a = stepAngle*i; // this is the final angle of the cloud
		var h = 750 + Math.random()*200; // this is the distance between the center of the axis and the cloud itself

		// Trigonometry!!! I hope you remember what you've learned in Math :)
		// in case you don't: 
		// we are simply converting polar coordinates (angle, distance) into Cartesian coordinates (x, y)
		c.mesh.position.y = Math.sin(a)*h;
		c.mesh.position.x = Math.cos(a)*h;

		// rotate the cloud according to its position
		c.mesh.rotation.z = a + Math.PI/2;

		// for a better result, we position the clouds 
		// at random depths inside of the scene
		c.mesh.position.z = -400-Math.random()*400;
		
		// we also set a random scale for each cloud
		var s = 1+Math.random()*2;
		c.mesh.scale.set(s,s,s);

		// do not forget to add the mesh of each cloud in the scene
		this.mesh.add(c.mesh);  
	}  
}

// Now we instantiate the sky and push its center a bit
// towards the bottom of the screen

var sky;

function createSky(){
	sky = new Sky();
	sky.mesh.position.y = -600;
	scene.add(sky.mesh);
}*/