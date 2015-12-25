# ParamountInvestmentGame
- 본프로젝트는 수원대학교 컴퓨터학과 소프트웨어 공학 수업에서 문승진 교수님 지휘 하에 진행 됐다.
- InvestmentGame Final Report
- 
	프로젝트를 구현함에 앞서 Software Engineering에 해당하는 리포트 작성에 집중해야 했다. 
	본 프로젝트에 첨부된 InvestmentGame Final Report가 이에 해당한다. 
	Report를 간략하게 소개하자면 이러하다. 
	1. 스토리(ST) - User가 본 서비스를 이용하기 위한 스토리(ST)를 기반으로 만든다. 
	2. 유즈 케이스(UC) - 스토리(ST)로부터 어떤 기능들을 요하는지에 대한 유즈 케이스(UC)를 파생한다. 
	3. 위로부터 파생되는 내용 - 각 UC에 해당하는 내용을 서로 다른 타이틀로 작성한다. 
   	ex) Interface(UC-1, UC-2, ...), Domain Model(UC-1, UC-2, ...), ...

- 프로젝트 구성
-
	- 본 프로젝트는 기본적으로 다음과 같이 구성 되었다. 
	1. Front-End : Android
	2. Back-End : PHP (APM 서버)
		참고- Sublime text2를 에디터로 이용하고 완성된 코드는 FileZilla를 이용해 서버에 올렸다. 
		      Sublime에서 컴파일을 시킬 수 없었기 때문에 Web에서 각 코드가 실행 되는지 확인하고
		      에러가 났다면 Putty를 이용해 올라간 소스를 서버에서 컴파일 시키고 디버그했다.

- 프로세스 고찰 
- 
	프로젝트를 완성한지 약 한달이 지난 지금 굉장히 비효율 적인 프로세스를 가지고 있었다는 것으로 생각된다. 
	Android와 Server의 Networking은 xml문을 출력하고 읽어오는 방식으로 이루어 졌다. 
	하지만 xml을 읽어오는 과정은 다른 네트워킹 방식과 비교해 봤을 때 굉장히 느리다. 
	Socket Networking을 이용 했어야 했다. 
	프로젝트를 진행한 "바람만스쳐도에러"팀은 Socket Programming에 문외했고 XML로 입출력 방식에 경험을 바탕으로 진행했지만, 
	이 프로젝트를 진행하고자 한다면 반드시 Socket으로 네트워킹 하길 바란다. 
	왜냐하면 그것이 훨씬 빠르고 본 프로젝트에서 서버로부터 데이터를 가지고 오는데 Delay를 경험했기 때문이다. 
	Network Infrastructure가 이렇게나 잘 돼있는 대한민국에서 데이터 송수신 Delay가 있다는 것은 큰 문제다.

- 후기 
- 
	처음 프로젝트를 진행하려 할 때 비관론자들이 많았다. 
	해보지 않은 분야에 대한 두려움이 앞섰고 4학년으로서 취업에 바쁘다는 얘기를 하곤 했다. 
	처음에는 Web App으로 Front End를 구성하려 했으나 Web App에 대한 경험이 없기 때문에 망설임이 컸다. 
	하지만 참고로 실제로 안드로이드보다 Web App 구현이 훨씬(!) 쉽고 Perfomance 또한 우리(허접)가 만드는 Android App보다 
	훨씬(!) 좋다.
	(웹앱은 Socket Networking도 필요없다.) 
	커뮤니케이션 능력도 정말 중요하다. 
	세상에 모든 프로젝트 절대 혼자 할 수 없다. 
	아무리 뛰어난 개발자가 혼자 하더라도 2명이서 개발하는 프로젝트보다 Perfomance가 안좋을 수 밖에 없다. 
	그러므로 내가 조금 잘 한다고 팀원에게 으시대거나 잘난척한다면 프로젝트는 실패할 확률이 높다. 	
	그런 사람들이 있다면 조를 짤 때 다른 조로 유인하거나 같은 조가 됐다면 과감하게 배척해라.

- 전하는 말
-
   	- 소프트웨어 공학 수업에서 본 프로젝트를 완성시킨 이가 말하고자 하는 것은 후년 Software Engineering 수업에 어떤 분야에
   	자신있는 개발자(학생)들이 참가할지 모르겠지만 
	1. 절대 새로운 분야 또는 학문에 도전하는 것을 두려워하지 말길 바란다. 
		ㄴ 취직을 하더라도 우리가 어떤 일을 하게 될지 절대 모른다. 새로운 분야 경험해 보지 못한 분야를 하게될 확률이 90%이다.
		ㄴ 새로운 학문이 어려울 것 같다는 막연한 두려움이 있을지 모르지만 Computer Science는 계속해서 더 쉽고 더 빠른 것을 
		추구하고 있다. 새로운 학문은 두렵지만 어렵지 않다. 
	2. 취업걱정 하지 마라. 
		ㄴ 이 프로젝트를 완성한다면 당신의 연봉을 최소 200만원 올려줄 것이다. 한학기(3개월반)동안 연봉 200만원 더 올리고
		취업하는 게 더 낫다.
		ㄴ 김소월이 써준 자소서 보다 훨씬더 큰 효과를 발휘할 것이다. 
		ㄴ 리포트를 최대한 많이 써서 두껍게 만들어라. 두꺼운 리포트를 면접 책상에 올려 놓으면 면접관들이 어디서 부터 봐야할지
		부담스러워하고 힘들어 한다. 소개를 해주자. 면접관들을 떡실신 시키자. 실제로 작성자는 그러고 있다.

Written By OST
