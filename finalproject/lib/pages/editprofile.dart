import 'dart:convert';
import 'package:finalproject/homepage.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:finalproject/user_provider.dart';
import 'package:http/http.dart' as http;

class EditProfile extends StatefulWidget {
  @override
  _EditProfileState createState() => _EditProfileState();
}

class _EditProfileState extends State<EditProfile> {
  final TextEditingController nameController = TextEditingController();
  final TextEditingController lastnameController = TextEditingController();
  final TextEditingController phoneController = TextEditingController();
  final TextEditingController emailController = TextEditingController();

  @override
  void initState() {
    super.initState();
    fetchCusProfile();
  }

  Future<void> fetchCusProfile() async {
    // URL API ที่ต้องการเรียก (แทนที่ด้วย URL ของ API จริง)
    final url = Uri.parse('http://127.0.0.1/barber/showprofile.php');
    final userProvider = Provider.of<UserProvider>(context, listen: false);
    try {
      final response = await http.post(
        url,
        body: {'cus_id': userProvider.getCusId()},
      );

      if (response.statusCode == 200) {
        final Map<String, dynamic> data = json.decode(response.body);
        final Map<String, dynamic> cusData = data['data'];

        // Use null-aware operators to handle null values
        String _name = cusData['cus_name'] ?? '';
        String _lastName = cusData['cus_lastname'] ?? '';
        String _phone = cusData['cus_phone'] ?? '';
        String _email = cusData['cus_email'] ?? '';
        setState(() {
          nameController.text = _name;
          lastnameController.text = _lastName;
          phoneController.text = _phone;
          emailController.text = _email;
        });
      } else {
        print('Unexpected data format');
      }
    } catch (error) {
      print('Error loading user profile: $error');
    }
  }

  Future<void> editUser(BuildContext context) async {
    final userProvider = Provider.of<UserProvider>(context, listen: false);
    final url = 'http://127.0.0.1/barber/edit.php';

    try {
      final response = await http.post(
        Uri.parse(url),
        body: {
          'cus_id': userProvider.getCusId(),
          'cus_name': nameController.text,
          'cus_lastname': lastnameController.text,
          'cus_phone': phoneController.text,
          'cus_email': emailController.text,
        },
      );

      if (response.statusCode == 200) {
        Map<String, dynamic> jsonResponse = json.decode(response.body);

        if (jsonResponse['status'] == "success") {
          ;
          print("อัพเดตสำเร็จ");
          Navigator.pushReplacement(
            context,
            MaterialPageRoute(
              builder: (context) => HomePage(),
            ),
          );
        } else {
          // showErrorDialog('เกิดข้อผิดพลาด: ${jsonResponse['message']}');
        }
      } else {
        // showErrorDialog('เกิดข้อผิดพลาด: ${response.reasonPhrase}');
      }
    } catch (error) {
      // showErrorDialog('เกิดข้อผิดพลาด: $error');
      print('เกิดข้อผิดพลาด: $error');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Edit Profile'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(20),
        child: ListView(
          children: [
            // รูปโปรไฟล์
            const SizedBox(height: 40),
            CircleAvatar(
              radius: 58,
              child: Stack(
                children: [
                  Align(
                    alignment: Alignment.bottomRight,
                    child: CircleAvatar(
                      radius: 18,
                      backgroundColor: Colors.white70
                    ),
                  ),
                ],
              ),
            ),

            // ชื่อ
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 25.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Name', // ข้อความที่คุณต้องการแสดง
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 16,
                    ),
                  ),
                  Container(
                    decoration: BoxDecoration(
                      color: Colors.white,
                      border: Border.all(color: Colors.grey),
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: Padding(
                      padding: const EdgeInsets.only(left: 20.0),
                      child: TextField(
                        controller: nameController,
                        decoration: InputDecoration(
                          border: InputBorder.none,
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ),
            SizedBox(height: 10),

            // สกุล
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 25.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'LastName', // ข้อความที่คุณต้องการแสดง
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 16,
                    ),
                  ),
                  Container(
                    decoration: BoxDecoration(
                      color: Colors.white,
                      border: Border.all(color: Colors.grey),
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: Padding(
                      padding: const EdgeInsets.only(left: 20.0),
                      child: TextField(
                        controller: lastnameController,
                        decoration: InputDecoration(
                          border: InputBorder.none,
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ),
            SizedBox(height: 10),

            // phone
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 25.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Phone', // ข้อความที่คุณต้องการแสดง
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 16,
                    ),
                  ),
                  Container(
                    decoration: BoxDecoration(
                      color: Colors.white,
                      border: Border.all(color: Colors.grey),
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: Padding(
                      padding: const EdgeInsets.only(left: 20.0),
                      child: TextField(
                        controller: phoneController,
                        decoration: InputDecoration(
                          border: InputBorder.none,
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ),
            SizedBox(height: 10),

            // email
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 25.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Email', // ข้อความที่คุณต้องการแสดง
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 16,
                    ),
                  ),
                  Container(
                    decoration: BoxDecoration(
                      color: Colors.white,
                      border: Border.all(color: Colors.grey),
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: Padding(
                      padding: const EdgeInsets.only(left: 20.0),
                      child: TextField(
                        controller: emailController,
                        decoration: InputDecoration(
                          border: InputBorder.none,
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ),
            SizedBox(height: 10),

            // ปุ่ม
            const SizedBox(
              height: 20,
            ),
            ElevatedButton(
              onPressed: () => editUser(context),
              style: ElevatedButton.styleFrom(
                padding: const EdgeInsets.all(15),
              ),
              child: const Text('ตกลง'),
            ),
          ],
        ),
      ),
    );
  }

  // Function to update profile information
  void _updateProfile(BuildContext context) {
    // Implement logic to update profile information
    // ...

    // Navigate back to the profile page after updating
    Navigator.pop(context);
  }
}
