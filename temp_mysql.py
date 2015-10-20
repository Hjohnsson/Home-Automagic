import time
import MySQLdb
from decimal import *
import datetime

count = 0
count_H = 0
TEMP_MIN = []
TEMP_H = []
min_result = 0
h_result = 0
not_valid_value = 0

while True:
	file = open("test.txt","r+")
	TEMP = file.readline()
	if TEMP =="":
		print "Not a valid value"
		not_valid_value +=1
		time.sleep(1)
	else:
		TEMP = Decimal(TEMP)/Decimal(10)

		TEMP1 = TEMP

		TIMESTAMP = datetime.datetime.now().time()
		TEXT = " Current temperature :"
		print str(TIMESTAMP) + TEXT + str(TEMP1)

		TEMP_MIN.append(TEMP)
		count += 1
		print "-"
		if count == 60:
			count = 0
			count_H += 1

			for i in TEMP_MIN:
				min_result = Decimal(min_result) + Decimal(i)


			del TEMP_MIN[:]
			getcontext().prec = 4
			flyt = Decimal(min_result)/Decimal(60)
			print "-----------"
			print "Minute value = "	+ str((Decimal(min_result)/Decimal(60-not_valid_value)))
			print "-----------"
			not_valid_value = 0

			TEMP_H.append(flyt)
		
			db = MySQLdb.connect("localhost","root","hj","temp")
			cursor = db.cursor()
			sql = """UPDATE temperatur SET temp = ('%s')""" % flyt
			try:
				cursor.execute(sql)
				db.commit()
				print "Succesfull update to database"
				print "-"
			except:
				db.rollback()
				print "error mysql"
			db.close()


			min_result = 0


		if count_H ==60:
			count_H = 0
			for i in TEMP_H:
				h_result = h_result + int(i)

			del TEMP_H[:]

			getcontext().prec = 4
			flyt_h = Decimal(h_result)/Decimal(60)
			print "-----------"
			print " 60 Minute value = " + str((Decimal(h_result)/Decimal(60)))
			print "-----------"


		time.sleep(1)
	


