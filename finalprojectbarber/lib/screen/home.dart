import 'package:flutter/material.dart';
import 'package:carousel_slider/carousel_slider.dart';

class UserHome extends StatelessWidget {
  final List<String> imageUrls = [
  'assets/1.png',
  'assets/2.png',
  // เพิ่มรูปภาพเพิ่มเติมตามต้องการ
];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        
      ),
      body: CarouselSlider(
        options: CarouselOptions(
          height: 200.0,
          enlargeCenterPage: true,
          autoPlay: true,
          aspectRatio: 16 / 9,
          autoPlayCurve: Curves.fastOutSlowIn,
          enableInfiniteScroll: true,
          autoPlayAnimationDuration: Duration(milliseconds: 800),
          viewportFraction: 0.8,
        ),
        items: imageUrls.map((imageUrl) {
          return Builder(
            builder: (BuildContext context) {
              return Container(
                width: MediaQuery.of(context).size.width,
                margin: EdgeInsets.symmetric(horizontal: 5.0),
                decoration: BoxDecoration(
                  color: Colors.amber,
                ),
                child: Image.network(
                  imageUrl,
                  fit: BoxFit.cover,
                ),
              );
            },
          );
        }).toList(),
      ),
    );
  }
}