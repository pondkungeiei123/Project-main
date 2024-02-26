import 'package:flutter/material.dart';

// user_provider.dart
class UserProvider extends ChangeNotifier {
  String _id = '';

  String get id => _id;

  void setCusId(String id) {
    _id = id;
    notifyListeners();
  }

  String getCusId() {
    return _id;
  }
}
