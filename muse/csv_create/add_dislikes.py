import pandas as pd
import numpy as np
import random
import decimal

data = pd.read_csv('track_new.csv')

likesCol = data['likes'].to_list()
data.drop('dislikes', axis =1, inplace=True)

dislikesCol= [int (x + x * float(decimal.Decimal(str(random.uniform(-0.333,0.5))))) for x in likesCol ]
#col= np.random.randint(size=len(data), low=10000, high=5000000)




data['dislikes'] = dislikesCol






data.to_csv('track_final.csv', sep=',', index=False)



data2= pd.read_csv('track_final.csv', index_col=False)
print(data2.head())

