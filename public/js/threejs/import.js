window.addEventListener('load', init , false)


function init (){
	
	createScene();
	loadModel();

	renderer.render(scene, camera);
}
var scene,camera,renderer,WIDTH,HEIGHT;
function createScene(){
	
	WIDTH = window.innerWidth;
	HEIGHT = window.innerHeight;

	FieldOfView = 60;
	aspectRatio = WIDTH/HEIGHT;
	nearPlane = 1;
	farPlane = 500;


	scene = new THREE.Scene();
	

	//Create camera

	camera = new THREE.PerspectiveCamera(FieldOfView,aspectRatio,nearPlane,farPlane);

	camera.position.x = 0;
	camera.position.y=100;
	camera.position.z = 0;

	renderer = new THREE.WebGLRenderer({alpha:true,antialias:true});

	renderer.setSize(WIDTH,HEIGHT);

	renderer.shadowMap.enabled= true;

	container = document.getElementById('world');

	container.appendChild(renderer.domElement);
}


var loader = new THREE.ObjectLoader();

function loadModel(){	
	loader.load("/js/threejs/slither.js",function ( obj ) {
		alert('rendererere');
	     scene.add( obj );
	});


	

}

