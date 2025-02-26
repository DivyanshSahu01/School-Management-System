<!-- g2.drawString("महारानी लक्ष्मीबाई विद्यापीठ", x, y);
y += 50;

g2.setFont(new Font("Arial", Font.PLAIN, 14));
g2.drawString("(उच्चतर माध्यमिक विद्यालय)", x, y);
y += 50;

g2.drawString("कैंप-1, तीन दर्शन मंदिर, जिला-दुर्ग (छ.ग.)", x, y);y += 20;
g2.drawString("दिनाँक:", x, y);y += 20;
g2.drawString("नाम:", x, y);x+=50;
g2.drawString("कक्षा:", x, y);y += 20;
g2.drawString("माह:", x, y);y += 20;
g2.drawString("1. प्रवेश शुल्क", x, y);y += 20;
g2.drawString("2. शिक्षण शुल्क", x, y);y += 20;
g2.drawString("3. परीक्षा शुल्क", x, y);y += 20;
g2.drawString("4. स्काउट शुल्क", x, y);y += 20;
g2.drawString("5. क्रीड़ा शुल्क", x, y);y += 20;
g2.drawString("6. निर्धन छात्र कोष", x, y);y += 20;
g2.drawString("7. रेडक्रॉस", x, y);y += 20;
g2.drawString("8. सहयोग राशि", x, y);y += 20;
g2.drawString("9. अन्य", x, y);y += 20;
g2.drawString("   योग", x, y);y += 20;
g2.drawString("   शब्दो में", x, y);y += 20; -->

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{env('APP_NAME')}}</title>
  <!-- <script src="assets/js/vue.global.js"></script> -->
</head>
<body>
  <h2 align="center">महारानी लक्ष्मीबाई विद्यापीठ</h2>
  <h3 align="center">(उच्चतर माध्यमिक विद्यालय)</h3>
  <h3 align="center">कैंप-1, तीन दर्शन मंदिर, जिला-दुर्ग (छ.ग.)</h3>
  <hr>
  <b>नाम: </b>{{$student['name']}}<br>
  <b>कक्षा: </b>{{$student['standard']}}<br>
  <b>माह: </b><br>
  <ol>
      <li>प्रवेश शुल्क: {{$admission_fee}}</li>
      <li>शिक्षण शुल्क: {{$monthly_fee}}</li>
      <li>परीक्षा शुल्क: {{$exam_fee}}</li>
      <li>अन्य: {{$other_fee}}</li>
  </ol>
  
  योग: {{$admission_fee + $monthly_fee + $exam_fee + $other_fee}}<br>
  <!-- शब्दो में:  -->
</body>
</html>