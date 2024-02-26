import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';


class MapPage extends StatefulWidget {
  @override
  _MapPageState createState() => _MapPageState();
}

class _MapPageState extends State<MapPage> {
  GoogleMapController? mapController;

  final LatLng initialPosition = const LatLng(13.7563, 100.5018); // ตำแหน่งเริ่มต้นในกรุงเทพ

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Map Page'),
      ),
      body: GoogleMap(
        onMapCreated: (controller) {
          setState(() {
            mapController = controller;
          });
        },
        initialCameraPosition: CameraPosition(
          target: initialPosition,
          zoom: 12.0,
        ),
        markers: {
          Marker(
            markerId: MarkerId('marker_1'),
            position: initialPosition,
            infoWindow: InfoWindow(
              title: 'My Marker',
              snippet: 'This is a custom marker.',
            ),
          ),
        },
      ),
    );
  }
}
