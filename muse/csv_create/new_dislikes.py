import pandas as pd
import numpy as np
import random
import decimal

data = pd.read_csv('track_new.csv')

likesCol = data['likes'].to_list()
data.drop('dislikes', axis =1, inplace=True)

dislikesCol= [int (x - x * float(decimal.Decimal(str(random.uniform(0.1,0.5))))) for x in likesCol ]
data['dislikes'] = dislikesCol

data.to_csv('track_lower.csv', sep=',', index=False)

data2= pd.read_csv('track_lower.csv', index_col=False)
print(data2.head())
