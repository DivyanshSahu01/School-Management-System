<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{env('APP_NAME')}}</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&display=swap');
    body{
      font-family: "Hind", sans-serif;
      font-weight: 400;
    }
  </style>
</head>
<body>
  <h2 align="center">महारानी लक्ष्मीबाई विद्यापीठ</h2>
  <h3 align="center">(उच्चतर माध्यमिक विद्यालय)</h3>
  <h3 align="center">कैंप-1, तीन दर्शन मंदिर, जिला-दुर्ग (छ.ग.)</h3>
  <hr>
  <b>दिनाँक: </b>{{$created_at}}<br>
  <b>नाम: </b>{{$student['name']}}<br>
  <b>कक्षा: </b>{{$student['standard']}}<br>
  <b>माह: </b>{{$months}}<br>
  <ol>
      <li>प्रवेश शुल्क: {{$admission_fee}}</li>
      <li>शिक्षण शुल्क: {{$monthly_fee}}</li>
      <li>परीक्षा शुल्क: {{$exam_fee}}</li>
      <li>अन्य: {{$other_fee}}</li>
  </ol>
  
  <b>योग: </b>{{$admission_fee + $monthly_fee + $exam_fee + $other_fee}}<br>
  <b>शब्दो में: </b>{{$amountInWords}}

  <script type="text/javascript">
    setTimeout(() => {
      window.print();
      window.close();
    }, 500);
  </script>
</body>
</html>