/**
 * 3D Car Fallback Generator
 * Creates a simple procedural car when GLTF models are not available
 */

import * as THREE from 'three';

export class CarFallbackGenerator {
    static createSimpleCar(color = '#ffffff') {
        const carGroup = new THREE.Group();
        
        // Car body (main chassis)
        const bodyGeometry = new THREE.BoxGeometry(4, 1, 2);
        const bodyMaterial = new THREE.MeshPhongMaterial({ 
            color: color,
            shininess: 100,
            specular: 0x222222
        });
        const body = new THREE.Mesh(bodyGeometry, bodyMaterial);
        body.position.y = 0.5;
        body.castShadow = true;
        body.receiveShadow = true;
        carGroup.add(body);
        
        // Car cabin (upper part)
        const cabinGeometry = new THREE.BoxGeometry(2.5, 1.2, 1.8);
        const cabinMaterial = new THREE.MeshPhongMaterial({ 
            color: color,
            shininess: 100,
            specular: 0x222222
        });
        const cabin = new THREE.Mesh(cabinGeometry, cabinMaterial);
        cabin.position.set(0, 1.6, 0);
        cabin.castShadow = true;
        cabin.receiveShadow = true;
        carGroup.add(cabin);
        
        // Windows
        const windowMaterial = new THREE.MeshPhongMaterial({ 
            color: 0x87CEEB,
            transparent: true,
            opacity: 0.3,
            shininess: 100
        });
        
        // Front windshield
        const frontWindowGeometry = new THREE.PlaneGeometry(2.4, 1);
        const frontWindow = new THREE.Mesh(frontWindowGeometry, windowMaterial);
        frontWindow.position.set(0, 1.8, 0.9);
        frontWindow.rotation.x = -0.2;
        carGroup.add(frontWindow);
        
        // Rear windshield
        const rearWindow = new THREE.Mesh(frontWindowGeometry, windowMaterial);
        rearWindow.position.set(0, 1.8, -0.9);
        rearWindow.rotation.x = 0.2;
        rearWindow.rotation.y = Math.PI;
        carGroup.add(rearWindow);
        
        // Side windows
        const sideWindowGeometry = new THREE.PlaneGeometry(1.8, 0.8);
        const leftWindow = new THREE.Mesh(sideWindowGeometry, windowMaterial);
        leftWindow.position.set(-0.9, 1.8, 0);
        leftWindow.rotation.y = Math.PI / 2;
        carGroup.add(leftWindow);
        
        const rightWindow = new THREE.Mesh(sideWindowGeometry, windowMaterial);
        rightWindow.position.set(0.9, 1.8, 0);
        rightWindow.rotation.y = -Math.PI / 2;
        carGroup.add(rightWindow);
        
        // Wheels
        const wheelGeometry = new THREE.CylinderGeometry(0.4, 0.4, 0.3, 16);
        const wheelMaterial = new THREE.MeshPhongMaterial({ 
            color: 0x333333,
            shininess: 30
        });
        
        // Wheel positions
        const wheelPositions = [
            [-1.5, 0, 1.2],   // Front left
            [1.5, 0, 1.2],    // Front right
            [-1.5, 0, -1.2],  // Rear left
            [1.5, 0, -1.2]    // Rear right
        ];
        
        wheelPositions.forEach(pos => {
            const wheel = new THREE.Mesh(wheelGeometry, wheelMaterial);
            wheel.position.set(pos[0], pos[1], pos[2]);
            wheel.rotation.z = Math.PI / 2;
            wheel.castShadow = true;
            wheel.receiveShadow = true;
            carGroup.add(wheel);
            
            // Wheel rims
            const rimGeometry = new THREE.CylinderGeometry(0.25, 0.25, 0.32, 8);
            const rimMaterial = new THREE.MeshPhongMaterial({ 
                color: 0x888888,
                shininess: 100
            });
            const rim = new THREE.Mesh(rimGeometry, rimMaterial);
            rim.position.set(pos[0], pos[1], pos[2]);
            rim.rotation.z = Math.PI / 2;
            carGroup.add(rim);
        });
        
        // Headlights
        const headlightGeometry = new THREE.SphereGeometry(0.2, 8, 8);
        const headlightMaterial = new THREE.MeshPhongMaterial({ 
            color: 0xffffcc,
            emissive: 0x444400,
            shininess: 100
        });
        
        const leftHeadlight = new THREE.Mesh(headlightGeometry, headlightMaterial);
        leftHeadlight.position.set(-0.8, 0.8, 1.1);
        carGroup.add(leftHeadlight);
        
        const rightHeadlight = new THREE.Mesh(headlightGeometry, headlightMaterial);
        rightHeadlight.position.set(0.8, 0.8, 1.1);
        carGroup.add(rightHeadlight);
        
        // Taillights
        const taillightMaterial = new THREE.MeshPhongMaterial({ 
            color: 0xff4444,
            emissive: 0x440000,
            shininess: 100
        });
        
        const leftTaillight = new THREE.Mesh(headlightGeometry, taillightMaterial);
        leftTaillight.position.set(-0.8, 0.8, -1.1);
        carGroup.add(leftTaillight);
        
        const rightTaillight = new THREE.Mesh(headlightGeometry, taillightMaterial);
        rightTaillight.position.set(0.8, 0.8, -1.1);
        carGroup.add(rightTaillight);
        
        // Grille
        const grilleGeometry = new THREE.PlaneGeometry(1.5, 0.5);
        const grilleMaterial = new THREE.MeshPhongMaterial({ 
            color: 0x222222,
            shininess: 50
        });
        const grille = new THREE.Mesh(grilleGeometry, grilleMaterial);
        grille.position.set(0, 0.7, 1.01);
        carGroup.add(grille);
        
        // License plate area
        const plateGeometry = new THREE.PlaneGeometry(0.8, 0.2);
        const plateMaterial = new THREE.MeshPhongMaterial({ 
            color: 0xffffff,
            shininess: 30
        });
        const plate = new THREE.Mesh(plateGeometry, plateMaterial);
        plate.position.set(0, 0.3, 1.01);
        carGroup.add(plate);
        
        // Store body material for color changes
        carGroup.userData.bodyMaterial = bodyMaterial;
        carGroup.userData.cabinMaterial = cabinMaterial;
        
        return carGroup;
    }
    
    static updateCarColor(carGroup, color) {
        if (carGroup.userData.bodyMaterial) {
            carGroup.userData.bodyMaterial.color.setHex(color.replace('#', '0x'));
        }
        if (carGroup.userData.cabinMaterial) {
            carGroup.userData.cabinMaterial.color.setHex(color.replace('#', '0x'));
        }
    }
}

export default CarFallbackGenerator;