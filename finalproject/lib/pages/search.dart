import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

import 'package:intl/intl.dart';

class CusSearch extends StatefulWidget {
  @override
  _CusSearchState createState() => _CusSearchState();
}

class _CusSearchState extends State<CusSearch> {
  TextEditingController _controller = TextEditingController();
  DateTime? _selectedDate;
  List<Map<String, dynamic>> _apiData = [];

  Future<void> _selectDate(BuildContext context) async {
    final DateTime? picked = await showDatePicker(
      context: context,
      initialDate: DateTime.now(),
      firstDate: DateTime(2000),
      lastDate: DateTime(2101),
    );
    if (picked != null) {
      setState(() {
        _selectedDate = picked;
        _controller.text = "${picked.day}/${picked.month}/${picked.year}";
      });
    }
  }

  void _confirmDate() async {
    try {
      if (_selectedDate != null) {
        String formattedDate = DateFormat('yyyy-MM-dd').format(_selectedDate!);
        print(formattedDate);

        final response = await http.post(
          Uri.parse('http://127.0.0.1/barber/showbarber.php'),
          body: {'search_date': formattedDate},
        );

        if (response.statusCode == 200) {
          final Map<String, dynamic> apiResponse = json.decode(response.body);
          if (apiResponse['result'] == 1) {
            setState(() {
              _apiData = List<Map<String, dynamic>>.from(apiResponse['data']);
            });
          } else {
            // Handle API error
            print('API Error: ${apiResponse['message']}');
          }
        } else {
          // Handle HTTP error
          print('HTTP Error: ${response.reasonPhrase}');
        }
      }
    } catch (e) {
      // Handle exceptions
      print('Error: $e');
    }
  }

  @override
  Widget build(BuildContext context) {
  return SingleChildScrollView(
    child: Column(
      children: [
        Padding(
          padding: const EdgeInsets.all(10.0),
          child: Row(
            children: [
              Expanded(
                child: TextField(
                  controller: _controller,
                  decoration: InputDecoration(
                    labelText: 'ค้นหาวันที่',
                    hintText: 'เลือกวันที่',
                    prefixIcon: Icon(Icons.calendar_today),
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.all(Radius.circular(10.0)),
                    ),
                  ),
                  onTap: () {
                    _selectDate(context);
                  },
                ),
              ),
              SizedBox(width: 10),
              ElevatedButton(
                onPressed: _selectedDate != null ? _confirmDate : null,
                child: Text('ยืนยัน'),
                style: ElevatedButton.styleFrom(
                  backgroundColor: Color.fromARGB(255, 245, 123, 57),
                  onPrimary: Colors.white,
                ),
              ),
            ],
          ),
        ),
        SizedBox(height: 10),
        if (_apiData.isNotEmpty)
          Column(
            children: _apiData.map((data) {
              return Padding(
                padding: const EdgeInsets.all(8.0),
                child: Card(
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(15.0),
                  ),
                  elevation: 5,
                  color: Color.fromARGB(255, 245, 123, 57),
                  child: ListTile(
                    leading: Icon(Icons.person),
                    title: DefaultTextStyle(
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: 20,
                        height: 1.5,
                      ),
                      child: Text(
                        data['user_name'] + " " + data['user_lastname'],
                      ),
                    ),
                    subtitle: RichText(
                      text: TextSpan(
                        text: 'Phone: ${data['user_phone']} \n'
                            'Start Date: ${data['job_startdate']}',
                        style: TextStyle(
                          color: Colors.white,
                          fontSize: 16,
                          height: 1.5,
                        ),
                      ),
                    ),
                  ),
                ),
              );
            }).toList(),
          ),
      ],
    ),
  );
}
}
