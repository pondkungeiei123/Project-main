import 'package:finalproject/homepage.dart';
import 'package:finalproject/login.dart';
import 'package:finalproject/pages/editprofile.dart';
import 'package:finalproject/pages/profile.dart';
import 'package:finalproject/register.dart';
import 'package:flutter/material.dart';
import 'package:finalproject/user_provider.dart';
import 'package:provider/provider.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider(
      create: (context) => UserProvider(),
      child: MaterialApp(
        title: 'Your App Title',
        theme: ThemeData(
          colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
          useMaterial3: true,
        ),
        initialRoute: '/login', // ระบุ initialRoute เพื่อกำหนดหน้าแรก
        routes: {
          '/login': (context) => LoginPage(),
          '/register': (context) => RegisterPage(),
          '/home': (context) => HomePage(),
          '/edit_profile': (context) => EditProfile(),
          '/profile': (context) => CusProfile(),
        },
      ),
    );
  }
}
