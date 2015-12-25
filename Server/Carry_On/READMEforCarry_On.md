- 서버내에서 데이터처리를 구동하는 PHP 파일들이다. 

1. GetFinance.php
	- YAHOO API에서 주식정보를 가지고 와서 DB에 적재시킨다.
2. total_money.php
	- 현재 현금과 주식의 가치를 합산하는 연산을 해준다.
3. CreateLeague.php
	- 리그가 끝나면 새로운 리그를 개최시켜 준다.
4. QueuingSystem.php
	- 큐잉 시스템을 설정해 놓기 위해 쓰인다. 
5. StockSearch.php
	- 새로운 주식을 검색할 때 그 주식을 DB에 입력시킨다. 이름만 입력시키면 GetFinance가 정보를 가지고 온다.

- 등등 시스템 내부적으로 계속해서 연산해 줘야 하는 부분은 이 폴더 내의 PHP 소스들에 해당한다. 
각각의 PHP파일의 INPUT OUTPUT 내용은 Final Report에 자세히 기재되어 있다. 
